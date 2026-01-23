import './style.css';
import Swiper from 'swiper/bundle';
import { Fancybox } from "@fancyapps/ui";

/**
 * Home Hero Slider
 */
const initHomeHero = () => {
  const thumbsSlider = document.querySelector('.thumbs-slider');
  const mainSlider = document.querySelector('.main-slider');
  const progressBar = document.getElementById("hero-progress-bar");

  let isGrowPhase = true;

  if (!thumbsSlider || !mainSlider) return;

  const thumbsSwiper = new Swiper(".thumbs-slider", {
    spaceBetween: 0,
    slidesPerView: 3,
    direction: 'vertical',
    watchSlidesProgress: true,
  });

  new Swiper(".main-slider", {
    spaceBetween: 0,
    speed: 1000,
    parallax: true,
    loop: true,
    thumbs: {
      swiper: thumbsSwiper,
    },
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    on: {
      slideChangeTransitionStart: function() {
        isGrowPhase = !isGrowPhase;
      },
      autoplayTimeLeft(s, time, progress) {
        if (!progressBar) return;
        if (isGrowPhase) {
          progressBar.style.bottom = "auto";
          progressBar.style.top = "0";
          progressBar.style.height = ((1 - progress) * 100) + "%";
        } else {
          progressBar.style.top = "auto";
          progressBar.style.bottom = "0";
          progressBar.style.height = (progress * 100) + "%";
        }
      },
      slideChange() {
         if (!progressBar) return;
         if (isGrowPhase) {
           progressBar.style.top = "0";
           progressBar.style.bottom = "auto";
           progressBar.style.height = "0%";
         } else {
           progressBar.style.top = "auto";
           progressBar.style.bottom = "0";
           progressBar.style.height = "100%";
         }
      }
    }
  });
};

/**
 * Interactive Select
 */
const initInteractiveSelect = () => {
  const section = document.getElementById('interactive-select');
  if (!section) return;

  // --- 1. Data Source ---
  const contentData = {
    bendigo: [
      {
        title: "Bendigo Leisurefest 2025",
        date: "18 - 21 September 2025",
        loc: "Bendigo Racecourse",
        btn: "TICKET ON SALE SOON"
      },
      {
        title: "Exhibitor List",
        date: "Explore over 200 exhibitors",
        loc: "Outdoor & Indoor",
        btn: "VIEW LIST"
      },
      {
        title: "Visitor Information",
        date: "Plan your trip",
        loc: "Parking & Maps",
        btn: "READ MORE"
      },
      {
        title: "Highlights",
        date: "What's on",
        loc: "Entertainment Stage",
        btn: "SEE SCHEDULE"
      }
    ],
    geelong: [
      {
        title: "Geelong Leisurefest 2025",
        date: "18 - 21 September 2025",
        loc: "Geelong Racecourse",
        btn: "TICKET ON SALE SOON"
      },
      {
        title: "Camping Accessories",
        date: "Huge discounts available",
        loc: "Hall A",
        btn: "BROWSE DEALS"
      },
      {
        title: "Kids Zone",
        date: "Family Friendly Fun",
        loc: "Lawn Area",
        btn: "LEARN MORE"
      }
    ],
    border: [
      {
        title: "Border Leisurefest Info",
        date: "Coming Soon 2025",
        loc: "Wodonga Racecourse",
        btn: "COMING SOON"
      },
      {
        title: "Places to Stay",
        date: "Accommodation Partners",
        loc: "Albury / Wodonga",
        btn: "BOOK NOW"
      }
    ]
  };

  // --- 2. Element References ---
  const trigger = document.getElementById('dropdown-trigger');
  const menu = document.getElementById('dropdown-menu');
  const selectedText = document.getElementById('selected-text');
  const expandedContent = document.getElementById('expanded-content');
  const swiperWrapper = document.getElementById('swiper-wrapper');
  const options = document.querySelectorAll('.option-btn');

  // --- 3. Initialize Swiper ---
  let cardSwiper = new Swiper('.card-slider', {
    slidesPerView: 1,
    spaceBetween: 20,
    watchOverflow: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      640: {
        slidesPerView: 2
      },
      1024: {
        slidesPerView: 3
      },
    }
  });

  // --- 4. Dropdown Logic ---
  trigger.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleMenu();
  });

  document.addEventListener('click', () => {
    menu.classList.add('opacity-0', 'invisible', '-translate-y-2');
  });

  function toggleMenu() {
    const isOpen = !menu.classList.contains('invisible');
    if (isOpen) {
      menu.classList.add('opacity-0', 'invisible', '-translate-y-2');
    } else {
      menu.classList.remove('opacity-0', 'invisible', '-translate-y-2');
    }
  }

  // --- 5. Selection & Content Update Logic ---
  options.forEach(btn => {
    btn.addEventListener('click', (e) => {
      const value = e.target.getAttribute('data-value');
      const text = e.target.textContent.trim();
      const data = contentData[value];

      selectedText.textContent = text;
      swiperWrapper.innerHTML = '';

      data.forEach(item => {
        const slideHTML = `
          <div class="swiper-slide h-auto">
            <div class="border border-white/30 rounded-lg p-8 h-full flex flex-col items-start hover:bg-civ-blue-600 transition-colors">
              <h3 class="text-[1.75rem] font-bold text-white mb-4 leading-tight">${item.title}</h3>
              <div class="grow">
                <p class="text-white font-bold mb-1">${item.date}</p>
                <p class="text-white/80">${item.loc}</p>
              </div>
              <button class="mt-8 bg-white text-civ-blue-600 font-bold text-sm px-6 py-3 uppercase hover:bg-gray-100 transition-colors cursor-pointer">
                ${item.btn}
              </button>
            </div>
          </div>
        `;
        swiperWrapper.insertAdjacentHTML('beforeend', slideHTML);
      });

      cardSwiper.update();
      cardSwiper.slideTo(0);
      expandedContent.classList.remove('max-h-0', 'opacity-0');
      expandedContent.classList.add('max-h-[800px]', 'opacity-100');
    });
  });
};

document.addEventListener('DOMContentLoaded', () => {
  initHomeHero();
  initInteractiveSelect();
  
  // Fancybox initialization
  Fancybox.bind("[data-fancybox]", {
    // Basic Options
    groupAll: true, // Group all items with the same data-fancybox name
    Thumbs: false,  // Hide the thumbnail strip (per your screenshot)
    Toolbar: {
      display: {
        left: [],
        middle: ["infobar"], // Shows "2 / 15" counter
        right: ["close"],
      },
    },
    // Customize the "Infobar" (Counter) to match your design
    l10n: {
      COUNTER: "%d / %d", // Format: 1 / 15
    },
  });
});

console.log('CIV Shows Theme Loaded');
