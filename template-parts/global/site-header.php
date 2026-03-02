<?php

/**
 * Template part for displaying the site header
 */

$logo_field = get_field('header_logo', 'option');
$logo_url = $logo_field['header_logo']['site_logo']['url'] ?? get_stylesheet_directory_uri() . "/assets/images/logo.png";

?>

<header id="site-header" class="site-header w-full fixed top-0 z-50 transition-all duration-1000">

  <div id="topbar" class="topbar h-2 xl:h-10 w-full bg-civ-blue-500 transition-all duration-1000 overflow-hidden"></div>

  <div id="main-header" class="main-header w-full transition-all duration-1000 bg-black/80">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

      <div id="header-inner" class="flex items-center relative gap-x-4 md:gap-x-8 xl:gap-x-14 transition-all duration-1000 py-2 md:py-4 xl:py-6">

        <div class="site-branding relative z-10 shrink-0">
          <a href="<?php echo esc_url(home_url('/')); ?>" class="block">
            <div id="logo-container" class="flex items-center justify-center overflow-hidden transition-all duration-1000 w-20 h-20 md:w-32 md:h-32 xl:w-40 xl:h-40">
              <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="w-full h-full object-cover">
            </div>
          </a>
        </div>

        <?php get_template_part('template-parts/global/site-navigation'); ?>

      </div>
    </div>
  </div>
</header>