<?php

/**
 * Template part for displaying the site navigation
 */

$menu_data = get_field('mega_menu', 'option');
$menu_items = $menu_data['menu_items'] ?? [];

?>

<div id="main-nav-wrapper" class="main-nav-wrapper flex justify-end grow border-b border-white/40 -translate-y-1/2 transition-all duration-300">

  <!-- Navigation -->
  <nav class="site-navigation hidden md:flex items-center gap-4 lg:gap-6">

    <?php if ($menu_items) : ?>
      <?php foreach ($menu_items as $index => $item) : ?>
        <?php
        $link = $item['menu_item'];
        $type = $item['submenu_type'];
        $title = $link['title'];
        $url = $link['url'];
        $target = $link['target'] ? 'target="_blank"' : '';
        $has_children = ($type === 'megamenu' || $type === 'dropdown');
        ?>

        <?php if ($index > 0) : ?>
          <span class="text-white/60">|</span>
        <?php endif; ?>

        <div class="group <?php echo $type === 'megamenu' ? 'static' : 'relative'; ?> py-8">
          <a href="<?php echo esc_url($url); ?>" <?php echo $target; ?> class="flex items-center text-white font-medium uppercase text-sm tracking-wide group-hover:text-shadow-md transition duration-500">
            <?php echo esc_html($title); ?>
            <?php if ($has_children) : ?>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:text-shadow-md transition duration-500 transform group-hover:-rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            <?php endif; ?>
          </a>

          <?php if ($type === 'megamenu') : ?>
            <?php
            $mega_items = $item['megamenu_items']['submenu_items'] ?? [];
            $heading = $item['megamenu_items']['heading_group']['menu_heading'] ?? '';
            $desc = $item['megamenu_items']['heading_group']['menu_description'] ?? '';
            $bg_image = $item['megamenu_items']['heading_group']['menu_background']['background']['background_image']['url'] ?? '';
            ?>
            <div class="absolute top-full left-0 w-full bg-white shadow-2xl opacity-0 invisible translate-y-12 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-500 z-50 transform origin-top">
              <div class="grid grid-cols-12 min-h-[450px]">
                <!-- Left Col -->
                <div class="col-span-3 relative overflow-hidden bg-gray-900">
                  <?php if ($bg_image) : ?>
                    <div class="absolute inset-0 bg-cover bg-center opacity-60" style="background-image: url('<?php echo esc_url($bg_image); ?>');"></div>
                  <?php endif; ?>
                  <div class="absolute inset-0 bg-linear-to-t from-black/90 to-transparent"></div>
                  <div class="relative z-10 p-10 h-full flex flex-col justify-center text-white">
                    <?php if ($heading) : ?><h2 class="text-3xl font-bold mb-4"><?php echo esc_html($heading); ?></h2><?php endif; ?>
                    <?php if ($desc) : ?><p class="text-sm leading-relaxed text-gray-200"><?php echo esc_html($desc); ?></p><?php endif; ?>
                  </div>
                </div>

                <!-- Middle Col (Links) -->
                <div class="col-span-4 py-10 bg-white border-r border-gray-100">
                  <ul class="space-y-0">
                    <?php foreach ($mega_items as $sub_index => $sub_item) :
                      $sub_link_title = $sub_item['submenu_item']['title'];
                      $sub_link_url = $sub_item['submenu_item']['url'];
                      $target_id = "content-{$index}-{$sub_index}";
                    ?>
                      <li>
                        <a href="<?php echo esc_url($sub_link_url); ?>"
                          class="megamenu-link flex items-center justify-between w-full py-4 pl-6 pr-4 border-b border-gray-100 text-sm font-bold uppercase text-gray-700 hover:text-civ-orange-500 hover:bg-gray-50 transition-all group/link"
                          data-target="<?php echo $target_id; ?>">
                          <?php echo esc_html($sub_link_title); ?>
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-0 group-hover/link:opacity-100 transition-opacity text-civ-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                          </svg>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>

                <!-- Right Col (Content) -->
                <div class="col-span-5 bg-gray-50 p-10 flex">
                  <?php foreach ($mega_items as $sub_index => $sub_item) :
                    $target_id = "content-{$index}-{$sub_index}";
                    $feat = $sub_item['featured'];
                    $f_img = $feat['image']['url'] ?? '';
                    $f_title = $feat['title'];
                    $f_desc = $feat['description'];
                    $f_link = $feat['link']; // is array: title, url, target
                    $hidden_class = $sub_index === 0 ? '' : 'hidden';
                  ?>
                    <div id="<?php echo $target_id; ?>" class="megamenu-content w-full <?php echo $hidden_class; ?>">
                      <?php if ($f_img) : ?>
                        <img src="<?php echo esc_url($f_img); ?>" alt="<?php echo esc_attr($f_title); ?>" class="w-full h-auto mb-6">
                      <?php endif; ?>
                      <h3 class="text-2xl font-semibold text-civ-orange-500 mb-2"><?php echo esc_html($f_title); ?></h3>
                      <p class="font-medium text-gray-900 mb-6"><?php echo esc_html($f_desc); ?></p>
                      <?php if ($f_link && !empty($f_link['url'])) : ?>
                        <a href="<?php echo esc_url($f_link['url']); ?>" class="inline-flex items-center font-medium text-black border-b border-black hover:text-civ-orange-500 hover:border-civ-orange-500 transition-colors">
                          <?php echo esc_html($f_link['title'] ?: 'Learn More'); ?>
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                          </svg>
                        </a>
                      <?php endif; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>

          <?php elseif ($type === 'dropdown') : ?>
            <?php
            $drop_items = $item['dropdown_menu_items']['submenu_items'] ?? [];
            ?>
            <div class="absolute top-full left-0 w-64 bg-white shadow-xl opacity-0 invisible translate-y-4 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50">
              <ul class="py-2">
                <?php foreach ($drop_items as $d_item) :
                  $d_link = $d_item['submenu_link'];
                ?>
                  <li>
                    <a href="<?php echo esc_url($d_link['url']); ?>" class="block px-6 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-civ-orange-500 transition-colors">
                      <?php echo esc_html($d_link['title']); ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>

          <?php endif; ?>

        </div>

      <?php endforeach; ?>
    <?php endif; ?>

    <span class="text-white/60">|</span>

    <button class="text-white hover:text-civ-orange-500 transition-colors p-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
    </button>

  </nav>

  <!-- Mobile Menu Toggle (Placeholder) -->
  <div class="md:hidden">
    <button class="text-gray-700 focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </div>

</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {

    // Mega Menu Logic
    const links = document.querySelectorAll('.megamenu-link');
    const contents = document.querySelectorAll('.megamenu-content');

    links.forEach(link => {
      link.addEventListener('mouseenter', () => {
        // Find the specific container (right col) for this mega menu instance
        // But since IDs are unique globally, we can just hide all contents?
        // Wait, multiple mega menus might exist.
        // The previous logic:
        // contents.forEach(content => content.classList.add('hidden'));
        // This hides content in ALL mega menus. That's fine if only one is open at a time (which is true for hover).
        // But cleaner would be to find the closest wrapper.
        // However, the original logic works fine as long as IDs are unique.

        const targetId = link.getAttribute('data-target');
        const targetContent = document.getElementById(targetId);

        if (targetContent) {
          // Hide only siblings in the same container?
          // The simplest way that matches original logic:
          // Hide ALL megamenu-contents.
          // Since we are hovering, only one mega menu is visible anyway.
          // Actually, if we have multiple mega menus, 'contents' selects ALL of them across the page.
          // This might be slightly buggy if we hover one mega menu, it hides content in another (invisible) one.
          // But effectively it doesn't matter.
          // Better approach: Hide content *within the same container*.

          const parentContainer = link.closest('.grid').querySelector('.col-span-5');
          const siblingContents = parentContainer.querySelectorAll('.megamenu-content');
          siblingContents.forEach(c => c.classList.add('hidden'));

          targetContent.classList.remove('hidden');

          // Handle active link state
          const siblingLinks = link.closest('ul').querySelectorAll('.megamenu-link');
          siblingLinks.forEach(l => l.classList.remove('text-civ-orange-500'));
          link.classList.add('text-civ-orange-500');
        }
      });
    });

    // Scroll Logic
    const header = document.getElementById('site-header');
    const topbar = document.getElementById('topbar');
    const mainHeader = document.getElementById('main-header');
    const logoContainer = document.getElementById('logo-container');
    const headerInner = document.getElementById('header-inner');
    const mainNavWrapper = document.getElementById('main-nav-wrapper');

    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        // Scrolled State
        topbar.style.height = '0.5rem'; // Shrink topbar
        mainHeader.classList.remove('bg-transparent');
        mainHeader.classList.add('bg-black/80', 'backdrop-blur-sm', 'shadow-md');

        logoContainer.classList.remove('w-24', 'h-24', 'md:w-32', 'md:h-32', 'xl:w-40', 'xl:h-40');
        logoContainer.classList.add('w-16', 'h-16', 'md:w-20', 'md:h-20');

        headerInner.classList.remove('py-4', 'xl:py-6');
        headerInner.classList.add('py-2');

        mainNavWrapper.classList.remove('-translate-y-1/2', 'border-b', 'border-white/40');

      } else {
        // Original State
        topbar.style.height = ''; // Revert to CSS default (h-10)
        mainHeader.classList.add('bg-transparent');
        mainHeader.classList.remove('bg-black/90', 'backdrop-blur-sm', 'shadow-md');

        logoContainer.classList.add('w-24', 'h-24', 'md:w-32', 'md:h-32', 'xl:w-40', 'xl:h-40');
        logoContainer.classList.remove('w-16', 'h-16', 'md:w-20', 'md:h-20');

        headerInner.classList.add('py-4', 'xl:py-6');
        headerInner.classList.remove('py-2');

        mainNavWrapper.classList.add('-translate-y-1/2', 'border-b', 'border-white/40');
      }
    });
  });
</script>