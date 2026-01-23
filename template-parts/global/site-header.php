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
          <a href="#" class="block">
            <div id="logo-container" class="w-24 h-24 md:w-32 md:h-32 xl:w-40 xl:h-40 flex items-center justify-center overflow-hidden transition-all duration-300">
              <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/logo.png" ?>" alt=" Caravan Industry Victoria" class="w-full h-full object-cover">
            </div>
          </a>
        </div>

        <div id="main-nav-wrapper" class="main-nav-wrapper flex justify-end grow border-b border-white/40 py-4 -translate-y-1/2 transition-all duration-300">

          <!-- Navigation -->
          <nav class="site-navigation hidden md:flex items-center gap-4 lg:gap-6">

            <div class="group static">

              <a href="#" class="flex items-center text-white font-medium uppercase text-sm tracking-wide group-hover:text-civ-orange-500 transition-colors py-4">
                Our Shows
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:text-civ-orange-500 transition-colors transform group-hover:-rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
              </a>

              <div class="absolute top-full left-0 w-full bg-white shadow-2xl border-t-4 border-civ-orange-500 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform origin-top">

                <div class="grid grid-cols-12 min-h-[450px]">

                  <div class="col-span-3 relative overflow-hidden bg-gray-900">
                    <div class="absolute inset-0 bg-cover bg-center opacity-60" style="background-image: url('https://placehold.co/600x800/1e456e/FFFFFF?text=Crowd+Image');"></div>
                    <div class="absolute inset-0 bg-linear-to-t from-black/90 to-transparent"></div>

                    <div class="relative z-10 p-10 h-full flex flex-col justify-center text-white">
                      <h2 class="text-3xl font-bold mb-4">Our Shows</h2>
                      <p class="text-sm leading-relaxed text-gray-200">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                      </p>
                    </div>
                  </div>

                  <div class="col-span-3 bg-white py-8 px-6 border-r border-gray-100">
                    <ul class="space-y-2">

                      <li>
                        <a href="#"
                          class="megamenu-link flex items-center justify-between w-full p-4 border-b border-gray-100 text-sm font-bold text-gray-700 hover:text-civ-orange-500 hover:bg-gray-50 transition-all group/link"
                          data-target="content-1">
                          MELBOURNE CARAVAN & CAMPING LEISUREFEST
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-0 group-hover/link:opacity-100 transition-opacity text-civ-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                          </svg>
                        </a>
                      </li>

                      <li>
                        <a href="#"
                          class="megamenu-link flex items-center justify-between w-full p-4 border-b border-gray-100 text-sm font-bold text-gray-700 hover:text-civ-orange-500 hover:bg-gray-50 transition-all group/link"
                          data-target="content-2">
                          BORDER CARAVAN & CAMPING LEISUREFEST
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-0 group-hover/link:opacity-100 transition-opacity text-civ-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                          </svg>
                        </a>
                      </li>

                      <li>
                        <a href="#"
                          class="megamenu-link flex items-center justify-between w-full p-4 border-b border-gray-100 text-sm font-bold text-gray-700 hover:text-civ-orange-500 hover:bg-gray-50 transition-all group/link"
                          data-target="content-3">
                          THE BENDIGO CARAVAN & CAMPING LEISUREFEST
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-0 group-hover/link:opacity-100 transition-opacity text-civ-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                          </svg>
                        </a>
                      </li>

                      <li>
                        <a href="#"
                          class="megamenu-link flex items-center justify-between w-full p-4 border-b border-gray-100 text-sm font-bold text-gray-700 hover:text-civ-orange-500 hover:bg-gray-50 transition-all group/link"
                          data-target="content-4">
                          VICTORIAN CARAVAN & CAMPING SUPERSHOW
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-0 group-hover/link:opacity-100 transition-opacity text-civ-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                          </svg>
                        </a>
                      </li>

                    </ul>
                  </div>

                  <div class="col-span-6 bg-gray-50 p-10 flex items-center">

                    <div id="content-1" class="megamenu-content w-full">
                      <img src="https://placehold.co/600x250/3374B8/FFFFFF?text=Melbourne+Show" alt="Melbourne Show" class="w-full h-48 object-cover mb-6 shadow-sm">
                      <h3 class="text-2xl font-bold text-civ-orange-500 mb-2">Melbourne Caravan & Camping Leisurefest</h3>
                      <p class="text-lg font-semibold text-gray-900 mb-6">18 - 21 September 2025, Sandown Racecourse</p>
                      <a href="#" class="inline-flex items-center font-bold text-black border-b-2 border-black hover:text-civ-orange-500 hover:border-civ-orange-500 transition-colors pb-1">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                      </a>
                    </div>

                    <div id="content-2" class="megamenu-content w-full hidden">
                      <img src="https://placehold.co/600x250/E6853B/FFFFFF?text=Border+Show" alt="Border Show" class="w-full h-48 object-cover mb-6 shadow-sm">
                      <h3 class="text-2xl font-bold text-civ-orange-500 mb-2">Border Caravan & Camping Leisurefest</h3>
                      <p class="text-lg font-semibold text-gray-900 mb-6">7 - 9 November 2025, Wodonga Racecourse</p>
                      <a href="#" class="inline-flex items-center font-bold text-black border-b-2 border-black hover:text-civ-orange-500 hover:border-civ-orange-500 transition-colors pb-1">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                      </a>
                    </div>

                    <div id="content-3" class="megamenu-content w-full hidden">
                      <img src="https://placehold.co/600x250/4FAC58/FFFFFF?text=Bendigo+Show" alt="Bendigo Show" class="w-full h-48 object-cover mb-6 shadow-sm">
                      <h3 class="text-2xl font-bold text-civ-orange-500 mb-2">The Bendigo Caravan & Camping Leisurefest</h3>
                      <p class="text-lg font-semibold text-gray-900 mb-6">21 - 23 November 2025, Bendigo Racecourse</p>
                      <a href="#" class="inline-flex items-center font-bold text-black border-b-2 border-black hover:text-civ-orange-500 hover:border-civ-orange-500 transition-colors pb-1">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                      </a>
                    </div>

                    <div id="content-4" class="megamenu-content w-full hidden">
                      <img src="https://placehold.co/600x250/9460B2/FFFFFF?text=Victorian+Supershow" alt="Supershow" class="w-full h-48 object-cover mb-6 shadow-sm">
                      <h3 class="text-2xl font-bold text-civ-orange-500 mb-2">Victorian Caravan & Camping Supershow</h3>
                      <p class="text-lg font-semibold text-gray-900 mb-6">18 - 22 February 2026, Melbourne Showgrounds</p>
                      <a href="#" class="inline-flex items-center font-bold text-black border-b-2 border-black hover:text-civ-orange-500 hover:border-civ-orange-500 transition-colors pb-1">
                        Learn More
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                      </a>
                    </div>

                  </div>

                </div>
              </div>
            </div>

            <span class="text-white/60">|</span>

            <a href="#" class="text-white font-medium uppercase text-sm tracking-wide hover:text-civ-orange-500 transition-colors">
              Exhibit With Us
            </a>

            <span class="text-white/60">|</span>

            <a href="#" class="text-white font-medium uppercase text-sm tracking-wide hover:text-civ-orange-500 transition-colors">
              About CIV
            </a>

            <span class="text-white/60">|</span>

            <a href="#" class="text-white font-medium uppercase text-sm tracking-wide hover:text-civ-orange-500 transition-colors">
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

<script>
  document.addEventListener('DOMContentLoaded', () => {

    // Mega Menu Logic

    const links = document.querySelectorAll('.megamenu-link');

    const contents = document.querySelectorAll('.megamenu-content');



    links.forEach(link => {

      link.addEventListener('mouseenter', () => {

        contents.forEach(content => content.classList.add('hidden'));

        const targetId = link.getAttribute('data-target');

        const targetContent = document.getElementById(targetId);

        if (targetContent) {

          targetContent.classList.remove('hidden');

        }

        links.forEach(l => l.classList.remove('text-civ-orange-500'));

        link.classList.add('text-civ-orange-500');

      });

    });



    // Scroll Logic

    const header = document.getElementById('site-header');
    const topbar = document.getElementById('topbar');
    const mainHeader = document.getElementById('main-header');
    const logoContainer = document.getElementById('logo-container');
    const headerInner = document.getElementById('header-inner');
    const mainNavWrapper = document.getElementById('main-nav-wrapper');

    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        // Scrolled State
        topbar.style.height = '0.5rem'; // Shrink topbar
        mainHeader.classList.remove('bg-transparent');
        mainHeader.classList.add('bg-black/80', 'backdrop-blur-sm', 'shadow-md');

        logoContainer.classList.remove('w-24', 'h-24', 'md:w-32', 'md:h-32', 'xl:w-40', 'xl:h-40');
        logoContainer.classList.add('w-16', 'h-16', 'md:w-20', 'md:h-20');

        headerInner.classList.remove('py-4', 'xl:py-6');
        headerInner.classList.add('py-2');

        mainNavWrapper.classList.remove('-translate-y-1/2', 'border-b', 'border-white/40');

      } else {
        // Original State
        topbar.style.height = ''; // Revert to CSS default (h-10)
        mainHeader.classList.add('bg-transparent');
        mainHeader.classList.remove('bg-black/90', 'backdrop-blur-sm', 'shadow-md');

        logoContainer.classList.add('w-24', 'h-24', 'md:w-32', 'md:h-32', 'xl:w-40', 'xl:h-40');
        logoContainer.classList.remove('w-16', 'h-16', 'md:w-20', 'md:h-20');

        headerInner.classList.add('py-4', 'xl:py-6');
        headerInner.classList.remove('py-2');

        mainNavWrapper.classList.add('-translate-y-1/2', 'border-b', 'border-white/40');
      }
    });

  });
</script>