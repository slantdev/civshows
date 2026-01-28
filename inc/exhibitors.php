<?php

/**
 * 1. Add "Import Exhibitors" Menu Page
 */
add_action('admin_menu', function () {
  add_submenu_page(
    'edit.php?post_type=exhibitors',
    'Import Exhibitors',
    'Import CSV',
    'manage_options',
    'import-exhibitors',
    'render_exhibitor_import_page'
  );
});

/**
 * 2. Render the Admin Upload Form (Updated with Loading Indicator)
 */
function render_exhibitor_import_page()
{
?>
  <div class="wrap">
    <h1>Import Exhibitors from CSV</h1>

    <?php
    // 1. Process CSV if submitted
    if (isset($_POST['exhibitor_import_nonce']) && wp_verify_nonce($_POST['exhibitor_import_nonce'], 'import_exhibitors')) {
      process_exhibitor_csv();
    }
    ?>

    <div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px; position: relative;">

      <p>Upload a CSV file (delimiter: <strong>;</strong>) to import exhibitors.</p>
      <p><strong>Required Columns:</strong> <code>Exhibitor_Name</code>, <code>Main_Category_1</code></p>
      <p><strong>Optional Columns:</strong> <code>Exhibitor_ID</code>, <code>Exhibitor_Headline</code>, <code>Bio</code>, <code>Main_Category_2</code>, <code>Logo_URL</code>, <code>Website</code>, <code>Instagram</code>, <code>Facebook</code></p>

      <form method="post" enctype="multipart/form-data" id="exhibitor-import-form">
        <?php wp_nonce_field('import_exhibitors', 'exhibitor_import_nonce'); ?>
        <input type="file" name="csv_file" required accept=".csv">
        <br><br>
        <input type="submit" name="submit" class="button button-primary" value="Start Import">
      </form>

      <div id="import-loading-overlay" style="display:none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.85); z-index: 10; align-items: center; justify-content: center; flex-direction: column; text-align: center;">
        <div class="spinner"></div>
        <p style="margin-top: 15px; font-weight: bold; font-size: 14px; color: #0073aa;">Importing Data...<br>Please do not close this window.</p>
      </div>

    </div>
  </div>

  <style>
    .spinner {
      width: 40px;
      height: 40px;
      border: 4px solid #f3f3f3;
      border-top: 4px solid #0073aa;
      /* WP Blue */
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>

  <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('exhibitor-import-form');
      var overlay = document.getElementById('import-loading-overlay');

      if (form) {
        form.addEventListener('submit', function() {
          // Show the overlay when form is submitted
          overlay.style.display = 'flex';
        });
      }
    });
  </script>
<?php
}

/**
 * 3. Helper: Format URLs (Lowercase + HTTPS)
 */
function format_exhibitor_url($url)
{
  if (empty($url)) return '';
  $url = strtolower(trim($url));
  if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
    $url = "https://" . $url;
  }
  return $url;
}

/**
 * 4. Helper: Sideload Image from URL
 */
function sideload_exhibitor_logo($url, $post_id)
{
  if (empty($url)) return false;

  require_once(ABSPATH . 'wp-admin/includes/media.php');
  require_once(ABSPATH . 'wp-admin/includes/file.php');
  require_once(ABSPATH . 'wp-admin/includes/image.php');

  $tmp = download_url($url);

  if (is_wp_error($tmp)) {
    return false;
  }

  $file_array = array();
  preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png|webp)/i', $url, $matches);
  $file_extension = isset($matches[0]) ? basename($matches[0]) : 'image.jpg';

  $file_array['name'] = 'logo-' . $post_id . '-' . $file_extension;
  $file_array['tmp_name'] = $tmp;

  $id = media_handle_sideload($file_array, $post_id);

  if (is_wp_error($id)) {
    @unlink($file_array['tmp_name']);
    return false;
  }

  return $id;
}

/**
 * 5. Helper: Find Post by Meta (Exhibitor ID)
 */
function get_exhibitor_by_id($exhibitor_id)
{
  $args = array(
    'post_type'  => 'exhibitors',
    'meta_key'   => 'exhibitor_id',
    'meta_value' => $exhibitor_id,
    'posts_per_page' => 1,
    'post_status' => 'any',
    'fields' => 'ids'
  );
  $posts = get_posts($args);
  return !empty($posts) ? $posts[0] : false;
}

/**
 * 6. Process the CSV File
 */
function process_exhibitor_csv()
{
  if (empty($_FILES['csv_file']['tmp_name'])) {
    echo '<div class="notice notice-error"><p>No file uploaded.</p></div>';
    return;
  }

  $file = $_FILES['csv_file']['tmp_name'];
  $handle = fopen($file, "r");

  if ($handle === FALSE) {
    echo '<div class="notice notice-error"><p>Could not read file.</p></div>';
    return;
  }

  // Get Headers (Delimiter is semicolon)
  $headers = fgetcsv($handle, 0, ";");

  // Clean headers
  $headers = array_map(function ($h) {
    return trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h));
  }, $headers);

  $success_count = 0;
  set_time_limit(300);

  while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {

    $row = array();
    foreach ($headers as $index => $key) {
      $row[$key] = isset($data[$index]) ? trim($data[$index]) : '';
    }

    // 1. Data Retrieval
    $title = isset($row['Exhibitor_Name']) ? $row['Exhibitor_Name'] : '';
    $csv_exhibitor_id = isset($row['Exhibitor_ID']) ? trim($row['Exhibitor_ID']) : '';

    if (empty($title)) continue;

    // 2. Find Post (ID Match -> Title Match -> New)
    $post_id = 0;

    if (!empty($csv_exhibitor_id)) {
      $post_id = get_exhibitor_by_id($csv_exhibitor_id);
    }

    if (!$post_id) {
      $post_id = post_exists($title, '', '', 'exhibitors');
    }

    $post_data = array(
      'post_title'   => $title,
      'post_type'    => 'exhibitors',
      'post_status'  => 'publish',
    );

    if ($post_id) {
      $post_data['ID'] = $post_id;
      wp_update_post($post_data);
    } else {
      $post_id = wp_insert_post($post_data);
    }

    if (is_wp_error($post_id)) continue;

    // 3. Taxonomy
    $term_ids = array();
    $category_columns = ['Main_Category_1', 'Main_Category_2'];

    foreach ($category_columns as $col) {
      if (!empty($row[$col])) {
        $term_name = $row[$col];
        $term = term_exists($term_name, 'exhibitor-category');
        if (!$term) {
          $term = wp_insert_term($term_name, 'exhibitor-category');
        }
        if (!is_wp_error($term) && $term) {
          $term_ids[] = (int) $term['term_id'];
        }
      }
    }

    if (!empty($term_ids)) {
      wp_set_object_terms($post_id, array_unique($term_ids), 'exhibitor-category');
    }

    // 4. Update ACF Fields
    if (function_exists('update_field')) {

      // --- A. Exhibitor Identity Group ---
      // Construct array from scratch.
      $identity_data = array(
        'exhibitor_id' => $csv_exhibitor_id
      );

      // Handle Logo
      $logo_url = isset($row['Logo_URL']) ? trim($row['Logo_URL']) : '';
      if (!empty($logo_url)) {
        $image_id = sideload_exhibitor_logo($logo_url, $post_id);
        if ($image_id) {
          $identity_data['exhibitor_logo'] = $image_id;
        }
      }

      // Update the Group
      update_field('exhibitor_identity', $identity_data, $post_id);


      // --- B. Exhibitor Description Group ---
      // Construct array from scratch
      $desc_data = array(
        'exhibitor_bio'      => isset($row['Bio']) ? $row['Bio'] : '',
        'exhibitor_headline' => isset($row['Exhibitor_Headline']) ? $row['Exhibitor_Headline'] : ''
      );

      // Update the Group
      update_field('exhibitor_description', $desc_data, $post_id);


      // --- C. Exhibitor Contact Group ---
      $website   = format_exhibitor_url($row['Website'] ?? '');
      $instagram = format_exhibitor_url($row['Instagram'] ?? '');
      $facebook  = format_exhibitor_url($row['Facebook'] ?? '');

      $contact_data = array(
        'phone_number'   => $row['Phone'] ?? '',
        'website_link'   => $website,
        'instagram_link' => $instagram,
        'facebook_link'  => $facebook,
      );

      update_field('exhibitor_contact', $contact_data, $post_id);
    }

    $success_count++;
  }

  fclose($handle);

  echo '<div class="notice notice-success is-dismissible"><p>Import complete! Processed ' . $success_count . ' exhibitors.</p></div>';
}
