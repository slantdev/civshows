<?php

/**
 * Component: Subscribe
 */
?>

<section class="flex flex-col md:flex-row w-full min-h-[500px]">

  <div class="w-full md:w-1/2 relative bg-gray-800">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/demo/Melbourne-@GAZiPHOTO_@Caravan-Industry-Victoria-.jpg' ?>');">
      <div class="absolute inset-0 bg-black/50"></div>
    </div>

    <div class="relative z-10 h-full flex flex-col justify-center px-8 md:px-16 py-12">
      <h2 class="text-4xl md:text-5xl font-semibold text-white mb-6">Join our mailing list</h2>
      <p class="text-xl md:text-2xl text-white max-w-lg">
        If you'd like to stay in the loop about our events join our mailing list!
      </p>
    </div>
  </div>

  <div class="w-full md:w-1/2 bg-civ-green-500 px-8 md:px-16 py-12 flex flex-col justify-center">

    <h2 class="text-3xl md:text-4xl font-semibold text-white mb-8">Subscribe Now</h2>

    <form class="w-full max-w-lg">

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

        <div class="relative">
          <input type="text" placeholder="First Name" class="w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
          </div>
        </div>

        <div class="relative">
          <input type="text" placeholder="Last Name" class="w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
          </div>
        </div>

        <div class="relative">
          <input type="email" placeholder="Email" class="w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>

        <div class="relative">
          <input type="text" placeholder="Postcode" class="w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </div>
        </div>

      </div>

      <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">

        <label class="flex items-center space-x-2 cursor-pointer group">
          <div class="relative flex items-center">
            <input type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-white/50 bg-white/20 checked:bg-white checked:border-white transition-all" checked>
            <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 text-civ-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </div>
          <span class="text-white text-sm font-medium select-none">I agree with all conditions</span>
        </label>

        <button type="button" class="bg-black hover:bg-gray-900 text-white font-bold py-3 px-12 rounded transition-colors w-full sm:w-auto text-center">
          Subscribe
        </button>
      </div>

    </form>
  </div>

</section>