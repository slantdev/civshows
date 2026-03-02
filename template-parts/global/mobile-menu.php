<?php

/**
 * Template part for displaying the mobile menu
 */

$menu_data = get_field('mega_menu', 'option');
$menu_items = $menu_data['menu_items'] ?? [];
$logo_field = get_field('header_logo', 'option');
$logo_url = $logo_field['header_logo']['site_logo']['url'] ?? get_stylesheet_directory_uri() . "/assets/images/logo.png";
$footer_social = get_field('social_links', 'option');
?>

<div id="mobile-menu-drawer" class="mobile-menu-drawer fixed inset-0 z-100 invisible pointer-events-none transition-all duration-300">
  <!-- Backdrop -->
  <div id="mobile-menu-backdrop" class="absolute inset-0 bg-black/60 opacity-0 transition-opacity duration-300"></div>

  <!-- Content -->
  <div id="mobile-menu-content" class="absolute top-0 right-0 w-4/5 max-w-sm h-full bg-white translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
    
    <div class="p-6 flex items-center justify-between border-b border-slate-100">
      <div class="w-20">
        <img src="<?php echo esc_url($logo_url); ?>" alt="Logo" class="w-full h-auto">
      </div>
      <button id="mobile-menu-close" class="text-gray-900 p-2 -mr-2" aria-label="Close Menu">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div class="grow overflow-y-auto py-6 px-6">
      <nav class="mobile-nav flex flex-col gap-1">
        <?php if ($menu_items) : ?>
          <?php foreach ($menu_items as $index => $item) :
            $link = $item['menu_item'];
            $type = $item['submenu_type'];
            $title = $link['title'];
            $url = $link['url'];
            $has_children = ($type === 'megamenu' || $type === 'dropdown');
            
            $sub_items = [];
            if ($type === 'megamenu') {
              $sub_items = $item['megamenu_items']['submenu_items'] ?? [];
            } elseif ($type === 'dropdown') {
              $sub_items = $item['dropdown_menu_items']['submenu_items'] ?? [];
            }
          ?>
            <div class="mobile-menu-item-wrapper border-b border-slate-100 last:border-0">
              <div class="flex items-center justify-between py-4">
                <a href="<?php echo esc_url($url); ?>" class="text-lg font-bold uppercase text-gray-900 tracking-wide">
                  <?php echo esc_html($title); ?>
                </a>
                
                <?php if ($has_children) : ?>
                  <button class="mobile-submenu-toggle p-2 text-gray-400" aria-label="Toggle Submenu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                  </button>
                <?php endif; ?>
              </div>

              <?php if ($has_children && $sub_items) : ?>
                <div class="mobile-submenu hidden overflow-hidden transition-all duration-300 bg-gray-50 -mx-6 px-6">
                  <ul class="py-2 space-y-1">
                    <?php foreach ($sub_items as $sub_item) :
                      $sub_link = $type === 'megamenu' ? $sub_item['submenu_item'] : $sub_item['submenu_link'];
                    ?>
                      <li>
                        <a href="<?php echo esc_url($sub_link['url']); ?>" class="block py-3 font-medium text-gray-700 hover:text-civ-orange-500">
                          <?php echo esc_html($sub_link['title']); ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </nav>
    </div>

    <div class="p-8 border-t border-gray-100 bg-civ-blue-500 text-white">
      <?php if (!empty($footer_social['social_media'])) : ?>
        <div class="flex items-center gap-6">
          <?php foreach ($footer_social['social_media'] as $social) :
            $platform = $social['social_media'] ?? '';
            $link     = $social['link'] ?? [];
            if ($link && $platform) :
            ?>
                <a href="<?php echo esc_url($link['url']); ?>"
                  target="<?php echo esc_attr($link['target'] ?: '_blank'); ?>"
                  class="hover:opacity-70 transition-colors"
                  title="<?php echo esc_attr($link['title'] ?: ucfirst($platform)); ?>">
                  <?php echo civ_get_social_icon($platform, 'w-7 h-7'); ?>
                </a>
            <?php endif;
          endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
