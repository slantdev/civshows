<?php

/**
 * Template part for displaying the site footer
 */

$current_id = get_the_ID();
$disable_subscribe = get_field('disable_subscribe', $current_id);

if (!$disable_subscribe) {
  $subscribe_group = get_field('subscribe', 'option')['subscribe'];
  $intro           = $subscribe_group['intro'] ?? [];
  $form_group      = $subscribe_group['form'] ?? [];
}
?>

<section class="civ-subscribe-section section-subscribe flex flex-col md:flex-row w-full min-h-[500px] relative overflow-x-hidden">

  <!-- Left Column: Intro -->
  <div class="civ-subscribe-intro-column intro-column w-full md:w-1/2 relative bg-gray-800">

    <?php if (!empty($intro['background'])) : ?>
      <?php get_template_part('template-parts/components/background', '', ['field' => $intro['background']]); ?>
    <?php endif; ?>

    <div class="civ-subscribe-intro-content relative z-10 h-full flex flex-col justify-center px-8 md:px-16 py-12 lg:py-24">
      <?php if (!empty($intro['intro_title'])) : ?>
        <div class="mb-6">
          <?php get_template_part('template-parts/components/heading', '', [
            'field' => $intro['intro_title'],
            'class' => ''
          ]); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($intro['intro_description'])) : ?>
        <div class="max-w-lg">
          <?php get_template_part('template-parts/components/heading', '', [
            'field' => $intro['intro_description'],
            'class' => ''
          ]); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Right Column: Form -->
  <div class="civ-subscribe-form-column form-column w-full md:w-1/2 relative px-8 md:px-16 py-12 lg:py-24 flex flex-col justify-center bg-civ-green-500">

    <?php if (!empty($form_group['background'])) : ?>
      <?php get_template_part('template-parts/components/background', '', ['field' => $form_group['background']]); ?>
    <?php endif; ?>

    <div class="civ-subscribe-form-content relative z-10">
      <?php if (!empty($form_group['form_title'])) : ?>
        <div class="mb-8">
          <?php get_template_part('template-parts/components/heading', '', [
            'field' => $form_group['form_title'],
            'class' => ''
          ]); ?>
        </div>
      <?php endif; ?>

      <div class="civ-subscribe-form-wrapper subscribe-form-wrapper w-full max-w-lg">
        <?php if (!empty($form_group['form_shortcode'])) : ?>
          <?php echo do_shortcode($form_group['form_shortcode']); ?>
        <?php else : ?>
          <!-- Fallback Static Form if no shortcode -->
          <form class="civ-subscribe-form w-full max-w-lg">

            <div class="civ-subscribe-fields grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

              <div class="civ-subscribe-input-group civ-subscribe-first-name-group relative">
                <input type="text" placeholder="First Name" class="civ-subscribe-input civ-subscribe-first-name-input w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
                <div class="civ-subscribe-input-icon absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
              </div>

              <div class="civ-subscribe-input-group civ-subscribe-last-name-group relative">
                <input type="text" placeholder="Last Name" class="civ-subscribe-input civ-subscribe-last-name-input w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
                <div class="civ-subscribe-input-icon absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
              </div>

              <div class="civ-subscribe-input-group civ-subscribe-email-group relative">
                <input type="email" placeholder="Email" class="civ-subscribe-input civ-subscribe-email-input w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
                <div class="civ-subscribe-input-icon absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>

              <div class="civ-subscribe-input-group civ-subscribe-postcode-group relative">
                <input type="text" placeholder="Postcode" class="civ-subscribe-input civ-subscribe-postcode-input w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
                <div class="civ-subscribe-input-icon absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>

            </div>

            <div class="civ-subscribe-actions flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">

              <label class="civ-subscribe-checkbox flex items-center space-x-2 cursor-pointer group">
                <div class="civ-subscribe-checkbox-wrapper relative flex items-center">
                  <input type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-white/50 bg-white/20 checked:bg-white checked:border-white transition-all" checked>
                  <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 text-civ-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                </div>
                <span class="civ-subscribe-checkbox-label text-white text-sm font-medium select-none">I agree with all conditions</span>
              </label>

              <button type="button" class="civ-subscribe-btn bg-black hover:bg-gray-900 text-white font-bold py-3 px-12 rounded transition-colors w-full sm:w-auto text-center">
                Subscribe
              </button>
            </div>

          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

</section>

<?php
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

<footer class="civ-site-footer border-t border-gray-200" style="<?php echo esc_attr($footer_styles); ?>">
  <div class="container mx-auto py-16 px-4 md:px-6 lg:px-8 xl:px-8">
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-12 gap-x-4 gap-y-8 lg:gap-8">

      <!-- About -->
      <div class="col-span-2 md:col-span-3 xl:col-span-5 flex flex-col md:flex-row gap-6 items-start xl:gap-8">
        <?php if (!empty($footer_about['logo'])) : ?>
          <div class="shrink-0">
            <div class="w-32 h-32 lg:w-36 lg:h-36 xl:w-42 xl:h-42 flex items-center justify-center">
              <?php echo wp_get_attachment_image($footer_about['logo']['id'], 'medium', false, ['class' => 'w-full h-full object-contain']); ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="civ-footer-about-content footer-about-content pr-0 xl:pr-6 prose prose-sm xl:max-w-none" style="color: inherit;">
          <?php if (!empty($footer_about['about_civ'])) : ?>
            <div class="[&_h3]:font-semibold [&_h3]:text-base [&_h3]:text-inherit [&_h3]:mb-4 [&_h3]:mt-0 [&_h3]:leading-tight [&_p]:text-sm [&_p]:leading-relaxed">
              <?php echo $footer_about['about_civ']; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Navigation -->
      <div class="civ-footer-navigation xl:col-span-2">
        <?php if (!empty($footer_nav['heading'])) : ?>
          <h3 class="font-bold text-base md:text-lg xl:text-lg mb-4 lg:mb-6" style="color: inherit; opacity: 0.8;"><?php echo esc_html($footer_nav['heading']); ?></h3>
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
                    class="civ-footer-nav-link hover:opacity-70 transition-colors">
                    <?php echo esc_html($link['title']); ?>
                  </a>
                </li>
            <?php endif;
            endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <!-- Contacts -->
      <div class="civ-footer-contacts xl:col-span-2">
        <?php if (!empty($footer_contacts['heading'])) : ?>
          <h3 class="font-bold text-base md:text-lg xl:text-lg mb-4 lg:mb-6" style="color: inherit; opacity: 0.8;"><?php echo esc_html($footer_contacts['heading']); ?></h3>
        <?php endif; ?>

        <div class="space-y-4 text-sm">
          <?php if (!empty($footer_contacts['address'])) : ?>
            <div class="leading-relaxed">
              <?php echo $footer_contacts['address']; ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($footer_contacts['phone'])) : ?>
            <p>
              <a href="tel:<?php echo esc_attr(str_replace(' ', '', $footer_contacts['phone'])); ?>" class="civ-footer-phone-link hover:opacity-70 transition-colors font-medium">
                <?php echo esc_html($footer_contacts['phone']); ?>
              </a>
            </p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Search & Social -->
      <div class="col-span-2 md:col-span-1 xl:col-span-3">
        <?php if (!empty($footer_search['enable_search_form'])) : ?>
          <h3 class="font-bold text-base md:text-lg xl:text-lg mb-4 lg:mb-6" style="color: inherit; opacity: 0.8;">Quick Search</h3>

          <form role="search" method="get" class="civ-footer-search-form flex gap-2 mb-8" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" name="s" placeholder="Enter keyword" class="w-full bg-gray-100 border-none rounded px-4 py-2 text-sm text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-civ-blue-500">
            <button type="submit" class="bg-civ-blue-500 hover:bg-civ-blue-600 text-white text-sm font-medium py-2 px-6 rounded transition-colors">
              Search
            </button>
          </form>
        <?php endif; ?>

        <?php if (!empty($footer_social['social_media'])) : ?>
          <h3 class="font-bold text-base md:text-lg xl:text-lg mb-4 lg:mb-6" style="color: inherit; opacity: 0.8;">Follow Us</h3>

          <div class="flex items-center gap-6">
            <?php foreach ($footer_social['social_media'] as $social) :
              $platform = $social['social_media'] ?? '';
              $link     = $social['link'] ?? [];
              if ($link && $platform) :
            ?>
                <a href="<?php echo esc_url($link['url']); ?>"
                  target="<?php echo esc_attr($link['target'] ?: '_blank'); ?>"
                  class="civ-footer-social-link hover:opacity-70 transition-colors"
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
  <div class="civ-footer-copyright py-4 w-full text-white" style="background-color: <?php echo esc_attr($copyright_bg_color); ?>;">
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
                class="civ-footer-copyright-link hover:underline transition-all">
                <?php echo esc_html($link['title']); ?>
              </a>
          <?php endif;
          endforeach; ?>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</footer>