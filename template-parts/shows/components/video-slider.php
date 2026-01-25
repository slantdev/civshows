<?php

/**
 * Video Slider
 */

?>

<section class="w-full bg-[#f2f2f2] py-20 md:py-28">
  <div class="container mx-auto px-4">

    <div class="text-center max-w-5xl mx-auto mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-black mb-6 leading-tight">
        The Melbourne Caravan & Camping Leisurefest<br>
        is on its way back to town!
      </h2>
      <p class="text-lg text-gray-800 font-medium">
        We're back for another epic show from the 18 - 21 of September 2025!
      </p>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 md:px-0">

      <div class="swiper town-slider rounded-xl overflow-hidden shadow-sm bg-gray-200">
        <div class="swiper-wrapper">

          <div class="swiper-slide relative aspect-16/10 group cursor-pointer">
            <img src="https://placehold.co/1000x625/333/999?text=Show+Highlight+Video" alt="Show Highlight" class="w-full h-full object-cover">

            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>

            <div class="absolute inset-0 flex items-center justify-center">
              <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border-[5px] border-white flex items-center justify-center pl-2 transition-transform duration-300 transform group-hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12 text-white fill-current" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
            </div>
          </div>

          <div class="swiper-slide relative aspect-16/10 group cursor-pointer">
            <img src="https://placehold.co/1000x625/1e456e/FFFFFF?text=Slide+2" alt="Slide 2" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="w-20 h-20 md:w-24 md:h-24 rounded-full border-[5px] border-white flex items-center justify-center pl-2 transition-transform duration-300 transform group-hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12 text-white fill-current" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="town-prev absolute top-1/2 -left-4 md:-left-16 transform -translate-y-1/2 z-10 cursor-pointer">
        <div class="w-12 h-12 rounded-full bg-gray-300 hover:bg-gray-400 flex items-center justify-center transition-colors text-white shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
        </div>
      </div>

      <div class="town-next absolute top-1/2 -right-4 md:-right-16 transform -translate-y-1/2 z-10 cursor-pointer">
        <div class="w-12 h-12 rounded-full bg-[#0070ad] hover:bg-[#005a8d] flex items-center justify-center transition-colors text-white shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </div>
      </div>

      <div class="town-pagination flex justify-center mt-8 gap-2"></div>

    </div>

  </div>
</section>

<style>
  /* Inactive Dot */
  .town-pagination .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: transparent;
    border: 2px solid #ccc;
    /* Outline style */
    opacity: 1;
    margin: 0 6px;
  }

  /* Active Dot */
  .town-pagination .swiper-pagination-bullet-active {
    background: #666;
    /* Solid Dark Gray */
    border-color: #666;
  }
</style>