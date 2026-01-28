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
 * 2. Render the Admin Upload Form
 */
function render_exhibitor_import_page()
{
?>
  <div class="wrap">
    <h1>Import Exhibitors from CSV</h1>

    <?php
    if (isset($_POST['exhibitor_import_nonce']) && wp_verify_nonce($_POST['exhibitor_import_nonce'], 'import_exhibitors')) {
      process_exhibitor_csv();
    }
    ?>

    <div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px;">
      <p>Upload a CSV file (delimiter: <strong>;</strong>) to import exhibitors.</p>
      <p><strong>Matching Logic:</strong> The script first tries to match by <code>Exhibitor_ID</code>. If not found, it attempts to match by <code>Exhibitor_Name</code>.</p>
      <p><strong>Required Columns:</strong> <code>Exhibitor_Name</code>, <code>Main_Category_1</code></p>
      <p><strong>Optional Columns:</strong> <code>Exhibitor_ID</code>, <code>Main_Category_2</code>, <code>Logo_URL</code>, <code>Website</code>, <code>Instagram</code>, <code>Facebook</code></p>

      <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('import_exhibitors', 'exhibitor_import_nonce'); ?>
        <input type="file" name="csv_file" required accept=".csv">
        <br><br>
        <input type="submit" name="submit" class="button button-primary" value="Start Import">
      </form>
    </div>
  </div>
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

    $title = isset($row['Exhibitor_Name']) ? $row['Exhibitor_Name'] : '';
    $csv_exhibitor_id = isset($row['Exhibitor_ID']) ? trim($row['Exhibitor_ID']) : '';

    if (empty($title)) continue;

    // --- 1. Find Post (Logic: ID Match -> Title Match -> New) ---
    $post_id = 0;

    // A. Try to find by Exhibitor_ID
    if (!empty($csv_exhibitor_id)) {
      $post_id = get_exhibitor_by_id($csv_exhibitor_id);
    }

    // B. Fallback: Try to find by Title if ID didn't match
    if (!$post_id) {
      $post_id = post_exists($title, '', '', 'exhibitors');
    }

    // Prepare Post Data
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

    // --- 2. Update Taxonomy (Multiple Main Categories) ---
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

    // --- 3. Update ACF Fields ---
    if (function_exists('update_field')) {
      // Save the Unique ID so we can match it next time
      if (!empty($csv_exhibitor_id)) {
        update_field('exhibitor_id', $csv_exhibitor_id, $post_id);
      }

      update_field('exhibitor_bio', $row['Bio'] ?? '', $post_id);

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

      // Image Handling
      $logo_url = isset($row['Logo_URL']) ? trim($row['Logo_URL']) : '';
      if (!empty($logo_url)) {
        $image_id = sideload_exhibitor_logo($logo_url, $post_id);
        if ($image_id) {
          update_field('exhibitor_logo', $image_id, $post_id);
        }
      }
    }

    $success_count++;
  }

  fclose($handle);

  echo '<div class="notice notice-success is-dismissible"><p>Import complete! Processed ' . $success_count . ' exhibitors.</p></div>';
}
