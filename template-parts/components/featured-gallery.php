<?php

/**
 * Component: Featured Gallery
 */

?>
<section class="py-24 bg-white">
  <div class="container mx-auto px-4 max-w-7xl">

    <h2 class="text-3xl md:text-4xl font-semibold text-civ-blue-900 mb-10">
      Featured Gallery:
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-18">

      <div class="group flex flex-col">
        <a href="<?php echo get_stylesheet_directory_uri() . "/assets/images/demo/featured1.jpg" ?>"
          data-fancybox="featured-gallery"
          data-caption="<h3 class='font-semibold text-lg mb-2'>South Melbourne's BIGGEST Show</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>"
          class="relative w-full aspect-4/5 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 block cursor-zoom-in">

          <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/demo/featured1.jpg" ?>" alt="Geelong Leisurefest" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

          <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>

          <div class="absolute top-8 left-8 z-10">
            <p class="text-white font-medium uppercase tracking-wide leading-tight drop-shadow-md">
              Featured Next Show -<br>Geelong Leisurefest
            </p>
          </div>

          <div class="absolute bottom-8 left-8 right-8 z-10 xl:bottom-20 xl:left-10 xl:right-10">
            <h3 class="text-white text-3xl xl:text-4xl font-medium leading-tight drop-shadow-md w-3/4">
              South Melbourne's BIGGEST caravan and camping show is back with new dates this October
            </h3>
          </div>

          <div class="absolute bottom-8 right-8 z-10">
            <div class="border-2 border-white rounded-md p-1 opacity-80 group-hover:opacity-100 group-hover:bg-white group-hover:text-civ-blue-900 text-white transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </div>
          </div>
        </a>

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-6 gap-4 xl:gap-6">
          <div class="text-civ-blue-900">
            <p class="font-medium text-lg leading-tight xl:text-xl">Returning from the</p>
            <p class="font-medium text-lg leading-tight xl:text-xl">18 - 21 September.</p>
          </div>
          <button class="w-full sm:w-auto bg-civ-blue-500 hover:bg-civ-blue-600 text-white font-semibold text-lg uppercase py-4 px-8 rounded transition-colors text-center cursor-pointer">
            Ticket On Sale Soon
          </button>
        </div>
      </div>

      <div class="group flex flex-col">
        <a href="<?php echo get_stylesheet_directory_uri() . "/assets/images/demo/featured2.jpg" ?>"
          data-fancybox="featured-gallery"
          data-caption="<h3 class='font-semibold text-lg mb-2'>Western Melbourne's BIGGEST Show</h3><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>"
          class="relative w-full aspect-4/5 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 block cursor-zoom-in">

          <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/demo/featured2.jpg" ?>" alt="Bendigo Leisurefest" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

          <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>

          <div class="absolute top-8 left-8 z-10">
            <p class="text-white font-medium uppercase tracking-wide leading-tight drop-shadow-md">
              Featured Next Show -<br>Bendigo Leisurefest
            </p>
          </div>

          <div class="absolute bottom-8 left-8 right-8 z-10 xl:bottom-20 xl:left-10 xl:right-10">
            <h3 class="text-white text-3xl xl:text-4xl font-medium leading-tight drop-shadow-md w-3/4">
              Western Melbourne's BIGGEST caravan and camping show is back with new dates this October
            </h3>
          </div>

          <div class="absolute bottom-8 right-8 z-10">
            <div class="border-2 border-white rounded-md p-1 opacity-80 group-hover:opacity-100 group-hover:bg-white group-hover:text-civ-blue-900 text-white transition-all">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </div>
          </div>
        </a>

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-6 gap-4">
          <div class="text-civ-blue-900">
            <p class="font-medium text-lg leading-tight xl:text-xl">Returning from the</p>
            <p class="font-medium text-lg leading-tight xl:text-xl">18 - 21 September.</p>
          </div>
          <button class="w-full sm:w-auto bg-civ-blue-500 hover:bg-civ-blue-600 text-white font-semibold text-lg uppercase py-4 px-8 rounded transition-colors text-center cursor-pointer">
            Ticket On Sale Soon
          </button>
        </div>
      </div>

    </div>
  </div>
</section>