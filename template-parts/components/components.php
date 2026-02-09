<?php

// Extracting field from args, ensuring it is an array
$field = isset($args['field']) && is_array($args['field']) ? $args['field'] : [];

// Outputting components if field is set
if (!empty($field)) {
  foreach ($field as $layout) {
    $acf_fc_layout = $layout['acf_fc_layout'] ?? '';
    
    // Outputting component template if layout is set
    if ($acf_fc_layout) {
      $template = 'template-parts/components/' . $acf_fc_layout;
      
      echo '<div class="component-wrapper mb-8 last:mb-0">';
      get_template_part($template, '', array('field' => $layout));
      echo '</div>';
    }
  }
}