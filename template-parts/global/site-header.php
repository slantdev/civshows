<?php

/**
 * Template part for displaying the site header
 */

?>

<header class="site-header w-full relative z-50">

  <div class="h-4 w-full bg-civ-blue-500"></div>

  <div class="bg-gray-500 w-full">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

      <div class="flex items-center relative py-4 xl:py-6 xl:space-x-12">

        <div class="site-branding relative z-10 shrink-0">
          <a href="#" class="block">
            <div class="w-24 h-24 md:w-32 md:h-32 xl:w-40 xl:h-40 flex items-center justify-center overflow-hidden">
              <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/logo.png" ?>" alt=" Caravan Industry Victoria" class="w-full h-full object-cover">
            </div>
          </a>
        </div>

        <div class="flex justify-end grow border-b border-white/90 py-4 -translate-y-1/2">

          <!-- Navigation -->
          <nav class="site-navigation hidden md:flex items-center gap-4 lg:gap-6">

            <div class="group relative flex items-center cursor-pointer">
              <a href="#" class="text-white font-bold uppercase text-sm tracking-wide hover:text-civ-orange-500 transition-colors">
                Our Shows
              </a>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white ml-1 group-hover:text-civ-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </div>

            <span class="text-white/60">|</span>

            <a href="#" class="text-white font-bold uppercase text-sm tracking-wide hover:text-civ-orange-500 transition-colors">
              Exhibit With Us
            </a>

            <span class="text-white/60">|</span>

            <a href="#" class="text-white font-bold uppercase text-sm tracking-wide hover:text-civ-orange-500 transition-colors">
              About CIV
            </a>

            <span class="text-white/60">|</span>

            <a href="#" class="text-white font-bold uppercase text-sm tracking-wide hover:text-civ-orange-500 transition-colors">
              Contact Us
            </a>

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

      </div>
    </div>
  </div>
</header>