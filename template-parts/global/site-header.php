<?php

/**
 * Template part for displaying the site header
 */

?>

<header id="site-header" class="site-header w-full fixed top-0 z-50 transition-all duration-300">

  <div id="topbar" class="topbar h-10 w-full bg-civ-blue-500 transition-all duration-300 overflow-hidden"></div>

  <div id="main-header" class="main-header bg-transparent w-full transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

      <div class="flex items-center relative py-4 xl:py-6 xl:space-x-12 transition-all duration-300" id="header-inner">

        <div class="site-branding relative z-10 shrink-0">
          <a href="/" class="block">
            <div id="logo-container" class="w-24 h-24 md:w-32 md:h-32 xl:w-40 xl:h-40 flex items-center justify-center overflow-hidden transition-all duration-300">
              <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/logo.png" ?>" alt=" Caravan Industry Victoria" class="w-full h-full object-cover">
            </div>
          </a>
        </div>

        <?php get_template_part('template-parts/global/site-navigation'); ?>

      </div>
    </div>
  </div>
</header>