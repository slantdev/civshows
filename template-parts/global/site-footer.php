<?php

/**
 * Template part for displaying the site footer
 */

$footer_about     = get_field('about', 'option');
$footer_nav       = get_field('navigation', 'option');
$footer_contacts  = get_field('contacts', 'option');
$footer_search    = get_field('search', 'option');
$footer_social    = get_field('social_links', 'option');
$footer_copyright = get_field('copyright_info', 'option'); // Cloned group
$footer_style     = get_field('footer_style', 'option');

// Styles
$text_color         = $footer_style['text_color'] ?? '#3374B8';
$bg_color           = $footer_style['background_color'] ?? '#FFFFFF';
$copyright_bg_color = $footer_style['copyright_bg_color'] ?? '#3374B8';

$footer_styles = "background-color: {$bg_color}; color: {$text_color};";

?>

<footer class="border-t border-gray-200" style="<?php echo esc_attr($footer_styles); ?>">
  <div class="container mx-auto py-16 px-4 xl:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8">

      <!-- About -->
      <div class="lg:col-span-5 flex flex-col sm:flex-row gap-6 items-start xl:gap-8">
        <?php if (!empty($footer_about['logo'])) : ?>
          <div class="shrink-0">
            <div class="w-42 h-42 flex items-center justify-center">
              <?php echo wp_get_attachment_image($footer_about['logo']['id'], 'medium', false, ['class' => 'w-full h-full object-contain']); ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="footer-about-content pr-6 prose prose-sm max-w-none" style="color: inherit;">
          <?php if (!empty($footer_about['about_civ'])) : ?>
            <div class="[&_h3]:font-semibold [&_h3]:text-base [&_h3]:text-inherit [&_h3]:mb-4 [&_h3]:mt-0 [&_h3]:leading-tight [&_p]:text-sm [&_p]:leading-relaxed">
              <?php echo $footer_about['about_civ']; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Navigation -->
      <div class="lg:col-span-2">
        <?php if (!empty($footer_nav['heading'])) : ?>
          <h3 class="font-bold text-lg mb-6" style="color: inherit; opacity: 0.8;"><?php echo esc_html($footer_nav['heading']); ?></h3>
        <?php endif; ?>

        <?php if (!empty($footer_nav['links'])) : ?>
          <ul class="space-y-2 text-sm">
            <?php foreach ($footer_nav['links'] as $item) :
              $link = $item['link'] ?? [];
              if ($link) :
            ?>
                <li>
                  <a href="<?php echo esc_url($link['url']); ?>"
                    target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
                    class="hover:opacity-70 transition-colors">
                    <?php echo esc_html($link['title']); ?>
                  </a>
                </li>
            <?php endif;
            endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <!-- Contacts -->
      <div class="lg:col-span-2">
        <?php if (!empty($footer_contacts['heading'])) : ?>
          <h3 class="font-bold text-lg mb-6" style="color: inherit; opacity: 0.8;"><?php echo esc_html($footer_contacts['heading']); ?></h3>
        <?php endif; ?>

        <div class="space-y-4 text-sm">
          <?php if (!empty($footer_contacts['address'])) : ?>
            <p class="leading-relaxed">
              <?php echo nl2br(esc_html($footer_contacts['address'])); ?>
            </p>
          <?php endif; ?>

          <?php if (!empty($footer_contacts['phone'])) : ?>
            <p>
              <a href="tel:<?php echo esc_attr(str_replace(' ', '', $footer_contacts['phone'])); ?>" class="hover:opacity-70 transition-colors font-medium">
                <?php echo esc_html($footer_contacts['phone']); ?>
              </a>
            </p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Search & Social -->
      <div class="lg:col-span-3">
        <?php if (!empty($footer_search['enable_search_form'])) : ?>
          <h3 class="font-bold text-lg mb-6" style="color: inherit; opacity: 0.8;">Quick Search</h3>

          <form role="search" method="get" class="flex gap-2 mb-8" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" name="s" placeholder="Enter keyword" class="w-full bg-gray-100 border-none rounded px-4 py-2 text-sm text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-civ-blue-500">
            <button type="submit" class="bg-civ-blue-500 hover:bg-civ-blue-600 text-white text-sm font-medium py-2 px-6 rounded transition-colors">
              Search
            </button>
          </form>
        <?php endif; ?>

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

  <!-- Copyright -->
  <?php
  $site_name  = $footer_copyright['copyright_site_name'] ?? get_bloginfo('name');
  $copy_links = $footer_copyright['copyright_links'] ?? [];
  ?>
  <div class="py-4 w-full text-white" style="background-color: <?php echo esc_attr($copyright_bg_color); ?>;">
    <div class="container mx-auto px-4 xl:px-8 text-sm font-medium flex flex-col md:flex-row justify-between items-center gap-4">
      <div>
        &copy; <?php echo date('Y'); ?>. <?php echo esc_html($site_name); ?>
      </div>

      <?php if (!empty($copy_links)) : ?>
        <nav class="flex flex-wrap justify-center gap-x-6 gap-y-2">
          <?php foreach ($copy_links as $item) :
            $link = $item['link'] ?? [];
            if ($link) :
          ?>
              <a href="<?php echo esc_url($link['url']); ?>"
                target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
                class="hover:underline transition-all">
                <?php echo esc_html($link['title']); ?>
              </a>
          <?php endif;
          endforeach; ?>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</footer>