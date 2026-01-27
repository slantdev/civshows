<?php

/**
 * Component: Exhibitors
 */

?>

<section class="w-full bg-white py-16 md:py-24">
  <div class="container mx-auto px-4">

    <div class="flex flex-col lg:flex-row items-center justify-between gap-12">

      <div class="w-full lg:w-1/2">
        <h2 class="text-3xl md:text-5xl font-semibold text-black mb-6">Exhibitors</h2>
        <p class="text-gray-700 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
          Explore the biggest brands and the latest products on off at the Melbourne Caravan & Camping Leisurefest. Come along to see the latest in caravans, camper trailers, motorhomes, and 4x4, plus a plethora of camping equipment, gadgets, and accessories bound to excite even the most seasoned outdoor lover!
        </p>
        <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm py-3 px-8 rounded-sm transition-colors shadow-sm">
          Download Map
        </button>
      </div>

      <div class="w-full lg:w-5/12 flex justify-center lg:justify-end -mb-28">
        <div class="w-full max-w-xl aspect-square rounded-full overflow-hidden relative">
          <img src="https://civshows.slantstaging.com.au/wp-content/uploads/2026/01/01.jpg" alt="Family at Exhibition" class="absolute inset-0 w-full h-full object-cover">
        </div>
      </div>
    </div>

    <div class="bg-gray-50 p-6 md:p-8 rounded-lg border border-gray-200 shadow-sm mb-12 z-30 relative">

      <div class="flex flex-col lg:flex-row gap-6 items-end lg:items-center border-b border-gray-200 pb-8 mb-6">

        <div class="w-full lg:w-5/12 space-y-2">
          <label class="font-extrabold text-sm uppercase text-black">Find By Category</label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="relative">
              <select class="w-full bg-white border border-gray-300 text-gray-700 text-sm rounded px-4 py-3 appearance-none focus:outline-none focus:border-civ-orange-500">
                <option>All Categories</option>
                <option>Caravans</option>
                <option>Motorhomes</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
            </div>
            <div class="relative">
              <select class="w-full bg-white border border-gray-300 text-gray-700 text-sm rounded px-4 py-3 appearance-none focus:outline-none focus:border-civ-orange-500">
                <option>All Sub Categories</option>
                <option>Off-Road</option>
                <option>Family</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <div class="hidden lg:flex items-center justify-center font-bold text-gray-400 text-sm uppercase px-2 h-12 mt-6">
          &mdash; OR &mdash;
        </div>

        <div class="w-full lg:w-5/12 space-y-2">
          <label class="font-extrabold text-sm uppercase text-black">Find By Keyword</label>
          <div class="flex">
            <input type="text" placeholder="Search by Name, State, Postcode ..." class="w-full bg-white border border-gray-300 border-r-0 rounded-l px-4 py-3 text-sm focus:outline-none focus:border-civ-orange-500">
            <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm px-6 rounded-r transition-colors">
              Search
            </button>
          </div>
        </div>

      </div>

      <div class="flex flex-col sm:flex-row gap-6 md:gap-12">

        <label class="flex items-center gap-3 cursor-pointer group">
          <div class="relative">
            <input type="checkbox" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500"></div>
          </div>
          <span class="text-sm font-bold text-black group-hover:text-civ-orange-500 transition-colors">New To The Show</span>
        </label>

        <label class="flex items-center gap-3 cursor-pointer group">
          <div class="relative">
            <input type="checkbox" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500"></div>
          </div>
          <span class="text-sm font-bold text-black group-hover:text-civ-orange-500 transition-colors">Has show specials!</span>
        </label>

      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">

      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
        <div class="h-48 overflow-hidden bg-gray-200">
          <img src="https://placehold.co/600x400/333/FFF?text=Brand+Image+1" alt="Exhibitor" class="w-full h-full object-cover transition-transform hover:scale-105 duration-500">
        </div>
        <div class="p-6 flex flex-col grow">
          <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1">Brand Name</h3>
          <p class="text-sm text-gray-500 italic mb-3">Category</p>
          <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
          <div class="space-y-1 mt-auto">
            <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600">(03) 9867 4567</span></p>
            <p class="text-sm font-bold text-black">Site:</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
        <div class="h-48 overflow-hidden bg-gray-200">
          <img src="https://placehold.co/600x400/555/FFF?text=Brand+Image+2" alt="Exhibitor" class="w-full h-full object-cover transition-transform hover:scale-105 duration-500">
        </div>
        <div class="p-6 flex flex-col grow">
          <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1">Brand Name</h3>
          <p class="text-sm text-gray-500 italic mb-3">Category</p>
          <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
          <div class="space-y-1 mt-auto">
            <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600">(03) 9867 4567</span></p>
            <p class="text-sm font-bold text-black">Site:</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
        <div class="h-48 overflow-hidden bg-gray-200">
          <img src="https://placehold.co/600x400/777/FFF?text=Brand+Image+3" alt="Exhibitor" class="w-full h-full object-cover transition-transform hover:scale-105 duration-500">
        </div>
        <div class="p-6 flex flex-col grow">
          <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1">Brand Name</h3>
          <p class="text-sm text-gray-500 italic mb-3">Category</p>
          <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          </p>
          <div class="space-y-1 mt-auto">
            <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600">(03) 9867 4567</span></p>
            <p class="text-sm font-bold text-black">Site:</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
        <div class="h-48 overflow-hidden bg-gray-200">
          <img src="https://placehold.co/600x400/999/FFF?text=Brand+Image+4" alt="Exhibitor" class="w-full h-full object-cover transition-transform hover:scale-105 duration-500">
        </div>
        <div class="p-6 flex flex-col grow">
          <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1">Brand Name</h3>
          <p class="text-sm text-gray-500 italic mb-3">Category</p>
          <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
          <div class="space-y-1 mt-auto">
            <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600">(03) 9867 4567</span></p>
            <p class="text-sm font-bold text-black">Site:</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
        <div class="h-48 overflow-hidden bg-gray-200">
          <img src="https://placehold.co/600x400/222/FFF?text=Brand+Image+5" alt="Exhibitor" class="w-full h-full object-cover transition-transform hover:scale-105 duration-500">
        </div>
        <div class="p-6 flex flex-col grow">
          <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1">Brand Name</h3>
          <p class="text-sm text-gray-500 italic mb-3">Category</p>
          <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          </p>
          <div class="space-y-1 mt-auto">
            <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600">(03) 9867 4567</span></p>
            <p class="text-sm font-bold text-black">Site:</p>
          </div>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
        <div class="h-48 overflow-hidden bg-gray-200">
          <img src="https://placehold.co/600x400/444/FFF?text=Brand+Image+6" alt="Exhibitor" class="w-full h-full object-cover transition-transform hover:scale-105 duration-500">
        </div>
        <div class="p-6 flex flex-col grow">
          <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1">Brand Name</h3>
          <p class="text-sm text-gray-500 italic mb-3">Category</p>
          <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          </p>
          <div class="space-y-1 mt-auto">
            <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600">(03) 9867 4567</span></p>
            <p class="text-sm font-bold text-black">Site:</p>
          </div>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
        <div class="h-48 overflow-hidden bg-gray-200">
          <img src="https://placehold.co/600x400/666/FFF?text=Brand+Image+7" alt="Exhibitor" class="w-full h-full object-cover transition-transform hover:scale-105 duration-500">
        </div>
        <div class="p-6 flex flex-col grow">
          <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1">Brand Name</h3>
          <p class="text-sm text-gray-500 italic mb-3">Category</p>
          <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          </p>
          <div class="space-y-1 mt-auto">
            <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600">(03) 9867 4567</span></p>
            <p class="text-sm font-bold text-black">Site:</p>
          </div>
        </div>
      </div>
      <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
        <div class="h-48 overflow-hidden bg-gray-200">
          <img src="https://placehold.co/600x400/888/FFF?text=Brand+Image+8" alt="Exhibitor" class="w-full h-full object-cover transition-transform hover:scale-105 duration-500">
        </div>
        <div class="p-6 flex flex-col grow">
          <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1">Brand Name</h3>
          <p class="text-sm text-gray-500 italic mb-3">Category</p>
          <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          </p>
          <div class="space-y-1 mt-auto">
            <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600">(03) 9867 4567</span></p>
            <p class="text-sm font-bold text-black">Site:</p>
          </div>
        </div>
      </div>

    </div>

    <div class="flex justify-center">
      <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm py-3 px-12 rounded-sm transition-colors shadow-sm">
        Load More
      </button>
    </div>

  </div>
</section>