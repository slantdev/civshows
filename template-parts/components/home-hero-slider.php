<?php

/**
 * Component: Home Hero Slider
 */
?>

<section class="relative w-full h-[600px] lg:h-[800px] xl:h-svh bg-civ-blue-950 overflow-hidden group">

  <div class="absolute left-0 h-full w-2 bg-black/50 z-30"></div>
  <div id="hero-progress-bar" class="absolute left-0 w-2 z-30 bg-civ-orange-500"></div>

  <div class="swiper main-slider w-full h-full">
    <div class="swiper-wrapper">
      <!-- Slide 1 -->
      <div class="swiper-slide relative flex items-center justify-center xl:pt-64">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/images/demo/DJI_20240830142858_0012_D-scaled.jpg" ?>');">
          <div class="absolute inset-0 bg-linear-to-b via-30% from-black/90 to-black/60 via-black/70"></div>
        </div>
        <div class="container mx-auto px-4 xl:px-8 relative z-10 grid grid-cols-1 md:grid-cols-12 h-full items-center">
          <div class="hidden md:block md:col-span-4 xl:col-span-5"></div>
          <div class="col-span-1 md:col-span-8 xl:col-span-7 text-white pl-8 md:pl-16">
            <h1 class="text-4xl md:text-6xl font-bold mb-4" data-swiper-parallax="-400">Bendigo Leisurefest 2025</h1>
            <p class="text-lg md:text-xl mb-8 max-w-2xl font-light" data-swiper-parallax="-700">
              21 - 23 November 2025 - Bendigo Racecourse: Victoria's biggest showcase of caravans, campers, and outdoor adventure.
            </p>
            <a href="#" class="inline-block bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold py-4 px-10 uppercase tracking-widest transition-all hover:scale-105 text-sm" data-swiper-parallax="-1000">
              Learn More
            </a>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="swiper-slide relative flex items-center justify-center xl:pt-64">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/images/demo/CIVSS25_Day3-03.jpg" ?>');">
          <div class="absolute inset-0 bg-linear-to-b via-30% from-black/90 to-black/60 via-black/70"></div>
        </div>
        <div class="container mx-auto px-4 xl:px-8 relative z-10 grid grid-cols-1 md:grid-cols-12 h-full items-center">
          <div class="hidden md:block md:col-span-4 xl:col-span-5"></div>
          <div class="col-span-1 md:col-span-8 xl:col-span-7 text-white pl-8 md:pl-16">
            <h1 class="text-4xl md:text-6xl font-bold mb-4" data-swiper-parallax="-400">Geelong Leisurefest</h1>
            <p class="text-lg md:text-xl mb-8 max-w-2xl font-light" data-swiper-parallax="-700">
              28 - 30 November 2025 - Geelong Racecourse: Victoria's biggest showcase of caravans, campers, and outdoor adventure.
            </p>
            <a href="#" class="inline-block bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold py-4 px-10 uppercase tracking-widest transition-all hover:scale-105 text-sm" data-swiper-parallax="-1000">
              Learn More
            </a>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="swiper-slide relative flex items-center justify-center xl:pt-64">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/images/demo/Melbourne-@GAZiPHOTO_@Caravan-Industry-Victoria-.jpg" ?>');">
          <div class="absolute inset-0 bg-linear-to-b via-30% from-black/90 to-black/60 via-black/70"></div>
        </div>
        <div class="container mx-auto px-4 xl:px-8 relative z-10 grid grid-cols-1 md:grid-cols-12 h-full items-center">
          <div class="hidden md:block md:col-span-4 xl:col-span-5"></div>
          <div class="col-span-1 md:col-span-8 xl:col-span-7 text-white pl-8 md:pl-16">
            <h1 class="text-4xl md:text-6xl font-bold mb-4" data-swiper-parallax="-400">Victorian Leisurefest 2026</h1>
            <p class="text-lg md:text-xl mb-8 max-w-2xl font-light" data-swiper-parallax="-700">
              18 - 20 February 2026 - Melbourne Showgrounds: Victoria's biggest showcase of caravans, campers, and outdoor adventure.
            </p>
            <a href="#" class="inline-block bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold py-4 px-10 uppercase tracking-widest transition-all hover:scale-105 text-sm" data-swiper-parallax="-1000">
              Learn More
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Thumbs Vertical Navigation -->
  <div class="absolute top-0 bottom-0 left-0 z-20 container mx-auto px-4 xl:px-8 xl:pt-64 pointer-events-none">
    <div class="h-full grid grid-cols-1 md:grid-cols-12 items-center">
      <div class="hidden md:flex md:col-span-4 lg:col-span-4 flex-col justify-center h-full pointer-events-auto pl-6">
        <div class="swiper thumbs-slider w-full max-w-96 overflow-visible!">
          <div class="swiper-wrapper flex-col">

            <!-- Thumb 1 -->
            <div class="swiper-slide h-auto! cursor-pointer transition-all duration-300">
              <div class="slide-thumb-wrapper p-6 relative transition-all duration-300">
                <div class="slide-thumb-indicator h-[3px]"></div>
                <div class="pt-3">
                  <h3 class="text-white font-bold text-xl mb-2">Bendigo Leisurefest 2025</h3>
                  <p class="text-gray-200 text-sm leading-relaxed font-bold">21-23 November 2025 - Bendigo Racecourse:</p>
                  <p class="text-gray-200 text-sm leading-relaxed">Victoria's biggest showcase of caravans, campers, and outdoor adventure.</p>
                </div>
              </div>
            </div>

            <!-- Thumb 2 -->
            <div class="swiper-slide h-auto! cursor-pointer transition-all duration-300">
              <div class="slide-thumb-wrapper p-6 relative transition-all duration-300">
                <div class="slide-thumb-indicator h-[3px]"></div>
                <div class="pt-3">
                  <h3 class="text-white font-bold text-xl mb-2">Geelong Leisurefest 2025</h3>
                  <p class="text-gray-200 text-sm leading-relaxed font-bold">28-30 November 2025 - Geelong Racecourse:</p>
                  <p class="text-gray-200 text-sm leading-relaxed">Victoria's biggest showcase of caravans, campers, and outdoor adventure.</p>
                </div>
              </div>
            </div>

            <!-- Thumb 3 -->
            <div class="swiper-slide h-auto! cursor-pointer transition-all duration-300">
              <div class="slide-thumb-wrapper p-6 relative transition-all duration-300">
                <div class="slide-thumb-indicator h-[3px]"></div>
                <div class="pt-3">
                  <h3 class="text-white font-bold text-lg mb-1">Victorian Leisurefest 2026</h3>
                  <p class="text-gray-200 text-sm leading-relaxed font-bold">18 - 20 February 2026 - Melbourne Showgrounds:</p>
                  <p class="text-gray-200 text-sm leading-relaxed">Victoria's biggest showcase of caravans, campers, and outdoor adventure.</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>