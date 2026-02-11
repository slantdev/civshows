<?php

/**
 * Template part for displaying the site header
 */

$logo_field = get_field('header_logo', 'option');
$logo_url = $logo_field['header_logo']['site_logo']['url'] ?? get_stylesheet_directory_uri() . "/assets/images/logo.png";

?>

<header id="site-header" class="site-header w-full fixed top-0 z-50 transition-all duration-300">

  <div id="topbar" class="topbar h-10 w-full bg-civ-blue-500 transition-all duration-300 overflow-hidden"></div>

  <div id="main-header" class="main-header bg-transparent w-full transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

      <div class="flex items-center relative py-4 xl:py-6 xl:gap-x-14 transition-all duration-300" id="header-inner">

        <div class="site-branding relative z-10 shrink-0">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="block">
            <div id="logo-container" class="w-24 h-24 md:w-32 md:h-32 xl:w-40 xl:h-40 flex items-center justify-center overflow-hidden transition-all duration-300">
              <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="w-full h-full object-cover">
            </div>
          </a>
        </div>

        <!-- Temporary -->
        <?php get_template_part('template-parts/global/site-navigation'); ?>

      </div>
    </div>
  </div>
</header>