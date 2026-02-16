<?php

/**
 * Exhibitor Post Type Logic
 * 
 * Handles Admin Columns, Filters, ACF relationship hooks, and CSV Import.
 */

// Prevent direct access
if (! defined('ABSPATH')) {
  exit;
}

// --- 1. Hooks & Filters ---

// ACF Field Filters
add_filter('acf/fields/relationship/query/name=exhibitor_shows', 'civ_exhibitor_filter_shows_query', 10, 3);

// Admin Columns
add_filter('manage_edit-exhibitors_columns', 'civ_exhibitor_admin_columns_head');
add_action('manage_exhibitors_posts_custom_column', 'civ_exhibitor_admin_columns_content', 10, 2);
add_filter('manage_edit-exhibitors_sortable_columns', 'civ_exhibitor_admin_columns_sortable');

// Admin Filtering & Sorting Logic
add_action('pre_get_posts', 'civ_exhibitor_admin_query_logic');
add_action('restrict_manage_posts', 'civ_exhibitor_admin_list_filters');

// Import Menu
add_action('admin_menu', 'civ_exhibitor_import_menu');


// --- 2. Admin UI & Logic Functions ---

/**
 * Filter ACF Relationship field to show only Top Level posts of 'shows' custom post type
 */
function civ_exhibitor_filter_shows_query($args, $field, $post_id)
{
  $args['post_parent'] = 0; // Strictly retrieve top-level shows
  return $args;
}

/**
 * Define Admin Columns
 */
function civ_exhibitor_admin_columns_head($columns)
{
  $new_columns = [];
  $new_columns['cb'] = $columns['cb'];
  $new_columns['exhibitor_id'] = 'ID';
  $new_columns['title'] = $columns['title'];
  $new_columns['exhibitor_shows'] = 'Shows';
  $new_columns['taxonomy-exhibitor-category'] = $columns['taxonomy-exhibitor-category'] ?? 'Category';
  $new_columns['date'] = $columns['date'];

  return $new_columns;
}

/**
 * Populate Admin Columns
 */
function civ_exhibitor_admin_columns_content($column, $post_id)
{
  switch ($column) {
    case 'exhibitor_id':
      $identity = get_field('exhibitor_identity', $post_id);
      echo esc_html($identity['exhibitor_id'] ?? '—');
      break;

    case 'exhibitor_shows':
      $shows = get_field('exhibitor_shows', $post_id);
      if ($shows) {
        $show_links = [];
        foreach ($shows as $show) {
          $show_id    = is_object($show) ? $show->ID : $show;
          $show_title = is_object($show) ? $show->post_title : get_the_title($show);
          $filter_url = add_query_arg(['post_type' => 'exhibitors', 'admin_filter_show' => $show_id], admin_url('edit.php'));
          $show_links[] = '<a href="' . esc_url($filter_url) . '">' . esc_html($show_title) . '</a>';
        }
        echo implode(', ', $show_links);
      } else {
        echo '—';
      }
      break;
  }
}

/**
 * Make Columns Sortable
 */
function civ_exhibitor_admin_columns_sortable($columns)
{
  $columns['exhibitor_id'] = 'exhibitor_id';
  return $columns;
}

/**
 * Handle Admin Query Logic (Sorting & Filtering)
 */
function civ_exhibitor_admin_query_logic($query)
{
  if (!is_admin() || !$query->is_main_query() || $query->get('post_type') !== 'exhibitors') {
    return;
  }

  // Sorting by ID
  if ($query->get('orderby') === 'exhibitor_id') {
    $query->set('meta_key', 'exhibitor_id');
    $query->set('orderby', 'meta_value');
  }

  // Filtering by Show (Relationship Field - LIKE search for serialized ID)
  if (!empty($_GET['admin_filter_show'])) {
    $show_id = sanitize_text_field($_GET['admin_filter_show']);
    $query->set('meta_query', [[
      'key'     => 'exhibitor_shows',
      'value'   => '"' . $show_id . '"',
      'compare' => 'LIKE'
    ]]);
  }
}

/**
 * Add Category & Show Filters to Admin List
 */
function civ_exhibitor_admin_list_filters()
{
  global $typenow;
  if ($typenow !== 'exhibitors') return;

  // 1. Category Filter
  $taxonomy = 'exhibitor-category';
  wp_dropdown_categories([
    'show_option_all' => 'All Categories',
    'taxonomy'        => $taxonomy,
    'name'            => $taxonomy,
    'orderby'         => 'name',
    'selected'        => $_GET[$taxonomy] ?? '',
    'show_count'      => true,
    'hide_empty'      => false,
    'value_field'     => 'slug',
    'hierarchical'    => true,
    'depth'           => 3,
  ]);

  // 2. Shows Filter
  $shows = get_posts(['post_type' => 'shows', 'post_parent' => 0, 'posts_per_page' => -1, 'post_status' => 'publish']);
  if ($shows) {
    $selected = $_GET['admin_filter_show'] ?? '';
    echo '<select name="admin_filter_show">';
    echo '<option value="">All Shows</option>';
    foreach ($shows as $show) {
      printf('<option value="%s" %s>%s</option>', $show->ID, selected($selected, $show->ID, false), esc_html($show->post_title));
    }
    echo '</select>';
  }
}


// --- 3. CSV Import Logic ---

/**
 * Add "Import Exhibitors" Submenu
 */
function civ_exhibitor_import_menu()
{
  add_submenu_page('edit.php?post_type=exhibitors', 'Import Exhibitors', 'Import CSV', 'manage_options', 'import-exhibitors', 'civ_exhibitor_render_import_page');
}

/**
 * Render Import Page
 */
function civ_exhibitor_render_import_page()
{
?>
  <div class="wrap">
    <h1>Import Exhibitors from CSV</h1>
    <?php if (isset($_POST['exhibitor_import_nonce']) && wp_verify_nonce($_POST['exhibitor_import_nonce'], 'import_exhibitors')) civ_exhibitor_process_csv(); ?>

    <div class="card" style="max-width: 600px; padding: 20px; margin-top: 20px; position: relative;">
      <p>Upload a CSV file (delimiter: <strong>;</strong>) to import exhibitors.</p>
      <p><strong>Required:</strong> <code>Exhibitor_Name</code>, <code>Main_Category_1</code></p>
      <form method="post" enctype="multipart/form-data" id="exhibitor-import-form">
        <?php wp_nonce_field('import_exhibitors', 'exhibitor_import_nonce'); ?>
        <input type="file" name="csv_file" required accept=".csv"><br><br>
        <input type="submit" name="submit" class="button button-primary" value="Start Import">
      </form>
      <div id="import-loading-overlay" style="display:none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.85); z-index: 10; align-items: center; justify-content: center; flex-direction: column; text-align: center;">
        <div class="spinner" style="width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #0073aa; border-radius: 50%; animation: civspin 1s linear infinite;"></div>
        <p style="margin-top: 15px; font-weight: bold; color: #0073aa;">Importing Data...</p>
      </div>
    </div>
  </div>
  <style>@keyframes civspin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }</style>
  <script>
    document.getElementById('exhibitor-import-form')?.addEventListener('submit', function() {
      document.getElementById('import-loading-overlay').style.display = 'flex';
    });
  </script>
<?php
}

/**
 * Process CSV File
 */
function civ_exhibitor_process_csv()
{
  if (empty($_FILES['csv_file']['tmp_name'])) return;

  $file = $_FILES['csv_file']['tmp_name'];
  $handle = fopen($file, "r");
  if ($handle === FALSE) return;

  $headers = array_map(fn($h) => trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h)), fgetcsv($handle, 0, ";"));
  $success_count = 0;
  set_time_limit(300);

  while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
    $row = array_combine($headers, array_pad($data, count($headers), ''));
    $title = $row['Exhibitor_Name'] ?? '';
    $csv_id = trim($row['Exhibitor_ID'] ?? '');
    if (empty($title)) continue;

    $post_id = $csv_id ? civ_exhibitor_get_by_id($csv_id) : post_exists($title, '', '', 'exhibitors');
    $post_data = ['post_title' => $title, 'post_type' => 'exhibitors', 'post_status' => 'publish'];
    if ($post_id) $post_data['ID'] = $post_id;

    $post_id = $post_id ? wp_update_post($post_data) : wp_insert_post($post_data);
    if (is_wp_error($post_id)) continue;

    // Taxonomy
    $terms = array_filter([$row['Main_Category_1'] ?? '', $row['Main_Category_2'] ?? '']);
    $term_ids = [];
    foreach ($terms as $name) {
      $term = term_exists($name, 'exhibitor-category') ?: wp_insert_term($name, 'exhibitor-category');
      if (!is_wp_error($term)) $term_ids[] = (int) $term['term_id'];
    }
    wp_set_object_terms($post_id, array_unique($term_ids), 'exhibitor-category');

    // ACF Updates
    if (function_exists('update_field')) {
      $logo_id = ($logo_url = trim($row['Logo_URL'] ?? '')) ? civ_exhibitor_sideload_logo($logo_url, $post_id) : null;
      update_field('exhibitor_identity', ['exhibitor_id' => $csv_id, 'exhibitor_logo' => $logo_id], $post_id);
      update_field('exhibitor_description', ['exhibitor_bio' => $row['Bio'] ?? '', 'exhibitor_headline' => $row['Exhibitor_Headline'] ?? ''], $post_id);
      update_field('exhibitor_contact', [
        'phone_number'   => $row['Phone'] ?? '',
        'website_link'   => civ_exhibitor_format_url($row['Website'] ?? ''),
        'instagram_link' => civ_exhibitor_format_url($row['Instagram'] ?? ''),
        'facebook_link'  => civ_exhibitor_format_url($row['Facebook'] ?? ''),
      ], $post_id);
    }
    $success_count++;
  }
  fclose($handle);
  echo '<div class="notice notice-success is-dismissible"><p>Import complete! Processed ' . $success_count . ' exhibitors.</p></div>';
}

/**
 * Helpers
 */
function civ_exhibitor_format_url($url) {
  if (empty($url)) return '';
  $url = strtolower(trim($url));
  return preg_match("~^(?:f|ht)tps?://~i", $url) ? $url : "https://" . $url;
}

function civ_exhibitor_get_by_id($id) {
  $posts = get_posts(['post_type' => 'exhibitors', 'meta_key' => 'exhibitor_id', 'meta_value' => $id, 'posts_per_page' => 1, 'post_status' => 'any', 'fields' => 'ids']);
  return $posts[0] ?? false;
}

function civ_exhibitor_sideload_logo($url, $post_id) {
  require_once(ABSPATH . 'wp-admin/includes/media.php');
  require_once(ABSPATH . 'wp-admin/includes/file.php');
  require_once(ABSPATH . 'wp-admin/includes/image.php');
  $tmp = download_url($url);
  if (is_wp_error($tmp)) return false;
  preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png|webp)/i', $url, $matches);
  $file = ['name' => 'logo-' . $post_id . '-' . ($matches[0] ?? 'image.jpg'), 'tmp_name' => $tmp];
  $id = media_handle_sideload($file, $post_id);
  if (is_wp_error($id)) @unlink($tmp);
  return is_wp_error($id) ? false : $id;
}