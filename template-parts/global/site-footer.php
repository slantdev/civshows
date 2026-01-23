<?php

/**
 * Template part for displaying the site footer
 */

?>

<footer class="bg-white border-t border-gray-200">
  <div class="container mx-auto py-16 px-4 xl:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8">

      <div class="lg:col-span-5 flex flex-col sm:flex-row gap-6 items-start xl:gap-8">
        <div class="shrink-0">
          <div class="w-42 h-42 flex items-center justify-center">
            <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/logo.png" ?>" alt=" Caravan Industry Victoria" class="w-full h-full object-cover">
          </div>
        </div>

        <div class="text-civ-blue-900 pr-6">
          <h3 class="font-bold text-base mb-4 leading-tight text-civ-blue-500">
            Caravan Industry Victoria - the team behind your favourite Caravan & Camping Shows, plus loads more you may not know.
          </h3>
          <p class="text-sm leading-relaxed text-slate-600">
            In 1952 the Caravan Trades and Industries Association of Victoria, trading as Caravan Industry Victoria, has been the peak industry body representing and supplying services to the caravan and camping industry right here in Victoria.
          </p>
        </div>
      </div>

      <div class="lg:col-span-2">
        <h3 class="font-bold text-lg text-civ-blue-500 mb-6">Navigation</h3>
        <ul class="space-y-2 text-civ-blue-500 text-sm">
          <li><a href="#" class="text-civ-blue-500 hover:text-civ-blue-700 hover:underline transition-colors">About CIV</a></li>
          <li><a href="#" class="text-civ-blue-500 hover:text-civ-blue-700 hover:underline transition-colors">Contact Us</a></li>
          <li><a href="#" class="text-civ-blue-500 hover:text-civ-blue-700 hover:underline transition-colors">Privacy Policy</a></li>
          <li><a href="#" class="text-civ-blue-500 hover:text-civ-blue-700 hover:underline transition-colors">Terms of Service</a></li>
        </ul>
      </div>

      <div class="lg:col-span-2">
        <h3 class="font-bold text-lg text-civ-blue-500 mb-6">Contacts</h3>
        <div class="space-y-2 text-civ-blue-500 text-sm">
          <p class="leading-relaxed">
            Unit 8 / 88 Dynon Road,<br />
            West Melbourne, VIC, 3003
          </p>
          <p>
            <a href="tel:1300762545" class="hover:text-civ-blue-700 hover:underline transition-colors">1300 762 545</a>
          </p>
        </div>
      </div>

      <div class="lg:col-span-3">
        <h3 class="font-bold text-lg text-civ-blue-500 mb-6">Quick Search</h3>

        <form class="flex gap-2 mb-8">
          <input type="text" placeholder="Enter keyword" class="w-full bg-gray-200 border-none rounded px-4 py-2 text-sm text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-civ-blue-500">
          <button type="button" class="bg-civ-blue-500 hover:bg-civ-blue-600 text-white text-sm font-medium py-2 px-6 rounded transition-colors">
            Search
          </button>
        </form>

        <div class="flex items-center gap-6">
          <a href="#" class="text-civ-blue-500 hover:text-civ-blue-600 transition-colors">
            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
            </svg>
          </a>
          <a href="#" class="text-civ-blue-500 hover:text-civ-blue-600 transition-colors">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
            </svg>
          </a>
          <a href="#" class="text-civ-blue-500 hover:text-civ-blue-600 transition-colors">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.373c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
            </svg>
          </a>
        </div>
      </div>

    </div>
  </div>
  <div class="py-3 w-full bg-civ-blue-500 text-white">
    <div class="container mx-auto px-4 xl:px-8 text-sm font-medium">
      &copy; 2026. Caravan Industry Victoria. All rights reserved.
    </div>
  </div>
</footer>