<?php

/**
 * Component: Page Header
 */

?>
<section class="w-full bg-civ-orange-500 relative">

  <div class="container mx-auto px-4 pt-12 pb-24 md:pt-20 md:pb-32 xl:pb-16 xl:px-8 xl:pt-72  ">
    <div class="flex flex-col md:flex-row items-center justify-between gap-12">
      <div class="w-full md:w-1/2 text-white">
        <h1 class="text-4xl md:text-5xl xl:text-6xl font-semibold leading-tight">
          Melbourne Leisurefest:<br>
          Ticket Information
        </h1>
      </div>
      <div class="w-full md:w-1/2 flex items-center justify-center">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/demo/logo-shows/melbourne.png' ?>" alt="Caravan Graphic" class="">
      </div>
    </div>
    <div class="flex">
      <div class="w-1/2">
        <div class="h-0.5 w-full bg-white/40 my-6"></div>

        <nav class="text-sm md:text-base font-medium text-white opacity-90">
          <ul class="flex items-center space-x-2">
            <li><a href="#" class="hover:underline">Our Shows</a></li>
            <li>/</li>
            <li><a href="#" class="hover:underline">Melbourne Leisurefest</a></li>
            <li>/</li>
            <li><span class="font-bold">Tickets</span></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <div class="w-full bg-civ-orange-500 border-b border-gray-300 bg-linear-to-r from-50% from-civ-orange-500 via-50% via-white to-white relative z-10">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row items-stretch md:items-center">

        <div class="text-white font-bold uppercase py-4 px-4 text-sm tracking-wide md:w-auto shrink-0 grow flex items-center justify-center md:justify-start">
          Melbourne Leisurefest
        </div>

        <div class="overflow-x-auto">
          <ul class="flex items-center whitespace-nowrap bg-white text-civ-blue-900 text-xs md:text-sm font-bold uppercase tracking-tight divide-x divide-gray-300 border-r border-gray-300">

            <li class="h-full">
              <a href="/shows/melbourne-leisurefest/" class="block py-4 px-6 hover:text-civ-orange-500 hover:bg-civ-orange-100 transition-colors">
                Tickets
              </a>
            </li>
            <li><a href="/shows/melbourne-leisurefest/visitor-information/" class="block py-4 px-6 hover:text-civ-orange-500 hover:bg-civ-orange-100 transition-colors">Visitor Information</a></li>
            <li><a href="/shows/melbourne-leisurefest/exhibitors/" class="block py-4 px-6 hover:text-civ-orange-500 hover:bg-civ-orange-100 transition-colors">Exhibitors</a></li>
            <li><a href="/shows/melbourne-leisurefest/gallery/" class="block py-4 px-6 hover:text-civ-orange-500 hover:bg-civ-orange-100 transition-colors">Gallery</a></li>
            <li><a href="/shows/melbourne-leisurefest/win/" class="block py-4 px-6 hover:text-civ-orange-500 hover:bg-civ-orange-100 transition-colors">Win!!</a></li>
            <li><a href="/shows/melbourne-leisurefest/map-visitor-guide/" class="block py-4 px-6 hover:text-civ-orange-500 hover:bg-civ-orange-100 transition-colors">Map & Visitor Guide</a></li>
            <li><a href="/shows/melbourne-leisurefest/whats-on/" class="block py-4 px-6 hover:text-civ-orange-500 hover:bg-civ-orange-100 transition-colors">What's On</a></li>

          </ul>
        </div>

      </div>
    </div>
  </div>

</section>