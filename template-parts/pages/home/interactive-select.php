<?php

/**
 * Component: Interactive Select
 */
?>

<section id="interactive-select" class="w-full bg-civ-blue-500 relative transition-all duration-500 ease-in-out">

  <div class="container mx-auto px-4 xl:px-8 py-16 relative z-20">

    <div class="flex flex-col md:flex-row items-center justify-center text-white text-3xl md:text-4xl font-light gap-3">

      <span class="shrink-0">I want to</span>

      <div class="relative group">

        <button id="dropdown-trigger" class="flex items-center gap-4 border-b-2 border-white/50 pb-1 hover:border-white transition-colors cursor-pointer text-left min-w-[300px] justify-between">
          <span id="selected-text" class="font-normal"></span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div id="dropdown-menu" class="absolute top-full left-0 w-full bg-white text-civ-blue-900 shadow-xl rounded-b-lg overflow-hidden opacity-0 invisible transform -translate-y-2 transition-all duration-200 z-50">
          <ul class="py-2 text-lg">
            <li>
              <button class="w-full text-left px-6 py-3 hover:bg-civ-blue-50 transition-colors option-btn" data-value="bendigo">
                visit the Bendigo Leisurefest
              </button>
            </li>
            <li>
              <button class="w-full text-left px-6 py-3 hover:bg-civ-blue-50 transition-colors option-btn" data-value="geelong">
                visit the Geelong Leisurefest
              </button>
            </li>
            <li>
              <button class="w-full text-left px-6 py-3 hover:bg-civ-blue-50 transition-colors option-btn" data-value="border">
                visit the Border Leisurefest
              </button>
            </li>
          </ul>
        </div>
      </div>

    </div>

    <div id="expanded-content" class="max-h-0 opacity-0 overflow-hidden transition-all duration-700 ease-in-out mt-0">

      <div class="pt-16 pb-4">
        <div class="swiper card-slider relative pb-14!">
          <div class="swiper-wrapper" id="swiper-wrapper">
          </div>

          <div class="swiper-pagination bottom-2!"></div>

          <div class="hidden md:flex absolute bottom-0 right-0 gap-2 z-10">
            <div class="swiper-button-prev static! w-10! h-10! mt-0! bg-white! hover:bg-gray-100! rounded-full p-3 flex items-center justify-center text-civ-blue-600! transition-colors after:text-sm!"></div>
            <div class="swiper-button-next static! w-10! h-10! mt-0! bg-white! hover:bg-gray-100! rounded-full p-3 flex items-center justify-center text-civ-blue-600! transition-colors after:text-sm!"></div>
          </div>

        </div>
      </div>

    </div>

  </div>

  <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-20 border-l-transparent border-r-20 border-r-transparent border-t-20 border-t-civ-blue-500 z-10"></div>

</section>