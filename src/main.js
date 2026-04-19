import "./style.css";
import Swiper from "swiper/bundle";
import { Fancybox } from "@fancyapps/ui";

/**
 * Home Hero Slider
 */
const initHomeHero = () => {
  const thumbsSlider = document.querySelector(".thumbs-slider");
  const mainSlider = document.querySelector(".main-slider");
  const progressBar = document.getElementById("hero-progress-bar");

  let isGrowPhase = true;

  if (!thumbsSlider || !mainSlider) return;

  const thumbsSwiper = new Swiper(".thumbs-slider", {
    spaceBetween: 0,
    slidesPerView: 3,
    direction: "vertical",
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
    pagination: {
      el: ".civ-home-hero-section .swiper-pagination",
      clickable: true,
    },
    autoplay: {
      delay: 6000,
      disableOnInteraction: false,
    },
    on: {
      slideChangeTransitionStart: function () {
        isGrowPhase = !isGrowPhase;
      },
      autoplayTimeLeft(s, time, progress) {
        if (!progressBar) return;
        if (isGrowPhase) {
          progressBar.style.bottom = "auto";
          progressBar.style.top = "0";
          progressBar.style.height = (1 - progress) * 100 + "%";
        } else {
          progressBar.style.top = "auto";
          progressBar.style.bottom = "0";
          progressBar.style.height = progress * 100 + "%";
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
      },
    },
  });
};

/**
 * Interactive Select
 */
const initInteractiveSelect = () => {
  const sections = document.querySelectorAll(".section-interactive-select");
  if (!sections.length) return;

  sections.forEach((section) => {
    // --- 1. Data Source ---
    const contentData = JSON.parse(
      section.getAttribute("data-interactive-content") || "{}",
    );

    // --- 2. Element References ---
    const trigger = section.querySelector(".dropdown-trigger");
    const menu = section.querySelector(".dropdown-menu");
    const selectedText = section.querySelector(".selected-text");
    const expandedContent = section.querySelector(".expanded-content");
    const swiperWrapper = section.querySelector(".swiper-wrapper");
    const options = section.querySelectorAll(".option-btn");

    // --- 3. Initialize Swiper ---
    let cardSwiper = new Swiper(section.querySelector(".card-slider"), {
      slidesPerView: 1,
      spaceBetween: 20,
      watchOverflow: true,
      pagination: {
        el: section.querySelector(".swiper-pagination"),
        clickable: true,
      },
      navigation: {
        nextEl: section.querySelector(".swiper-button-next"),
        prevEl: section.querySelector(".swiper-button-prev"),
      },
      breakpoints: {
        640: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    });

    // --- 4. Dropdown Logic ---
    trigger.addEventListener("click", (e) => {
      e.stopPropagation();
      toggleMenu();
    });

    document.addEventListener("click", () => {
      if (!menu.classList.contains("invisible")) {
        const translateClass = menu.classList.contains("bottom-0")
          ? "translate-y-2"
          : "-translate-y-2";
        menu.classList.add("opacity-0", "invisible", translateClass);
      }
    });

    function toggleMenu() {
      const isOpen = !menu.classList.contains("invisible");

      if (!isOpen) {
        const rect = trigger.getBoundingClientRect();
        const spaceBelow = window.innerHeight - rect.bottom;
        const requiredSpace = menu.scrollHeight + 20;

        if (spaceBelow < requiredSpace) {
          menu.classList.remove("top-full", "rounded-b-lg", "-translate-y-2");
          menu.classList.add("bottom-0", "rounded-t-lg", "translate-y-2");
        } else {
          menu.classList.remove("bottom-0", "rounded-t-lg", "translate-y-2");
          menu.classList.add("top-full", "rounded-b-lg", "-translate-y-2");
        }
      }

      if (isOpen) {
        const translateClass = menu.classList.contains("bottom-0")
          ? "translate-y-2"
          : "-translate-y-2";
        menu.classList.add("opacity-0", "invisible", translateClass);
      } else {
        menu.classList.remove(
          "opacity-0",
          "invisible",
          "-translate-y-2",
          "translate-y-2",
        );
      }
    }

    // --- 5. Selection & Content Update Logic ---
    options.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        const value = e.target.getAttribute("data-value");
        const text = e.target.textContent.trim();
        const data = contentData[value]?.cards || [];

        selectedText.textContent = text;
        swiperWrapper.innerHTML = "";

        data.forEach((item) => {
          const slideHTML = `
            <div class="swiper-slide h-auto">
              <div class="border border-white/30 rounded-lg p-8 h-full flex flex-col items-start bg-civ-blue-600 transition-colors">
                <h3 class="text-[1.75rem] font-bold text-white mb-4 leading-tight">${item.title}</h3>
                <div class="grow">
                  <p class="text-white font-bold mb-1">${item.subtitle}</p>
                  <p class="text-white/80">${item.category}</p>
                </div>
                <a href="${item.btn_url}" target="${item.btn_target}" class="mt-8 bg-white text-civ-blue-600 font-bold text-sm px-6 py-3 uppercase hover:bg-gray-300 transition-colors cursor-pointer inline-block">
                  ${item.btn_text}
                </a>
              </div>
            </div>
          `;
          swiperWrapper.insertAdjacentHTML("beforeend", slideHTML);
        });

        cardSwiper.update();
        cardSwiper.slideTo(0);
        expandedContent.classList.remove("max-h-0", "opacity-0");
        expandedContent.classList.add("max-h-[800px]", "opacity-100");

        // Scroll to the section smoothly right under the site header (with a slight delay for better transition syncing)
        setTimeout(() => {
          const yOffset = -120;
          const y =
            section.getBoundingClientRect().top + window.scrollY + yOffset;

          if (typeof jQuery !== "undefined") {
            jQuery("html, body").animate({ scrollTop: y }, 600);
          } else {
            window.scrollTo({ top: y, behavior: "smooth" });
          }
        }, 100);
      });
    });
  });
};

/**
 * Exibitor Special
 */
const initExhibitorSpecial = () => {
  const specialsSwiper = new Swiper(".specials-slider", {
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    effect: "fade", // Optional: Fading effect looks nice for single slides
    fadeEffect: {
      crossFade: true,
    },
  });
};

const initMediaSlider = () => {
  const wrappers = document.querySelectorAll(".media-slider-wrapper");
  if (!wrappers.length) return;

  wrappers.forEach((wrapper) => {
    const slider = wrapper.querySelector(".media-slider");
    const prevEl = wrapper.querySelector(".media-prev");
    const nextEl = wrapper.querySelector(".media-next");
    const paginationEl = wrapper.querySelector(".media-pagination");

    if (!slider) return;

    new Swiper(slider, {
      loop: true,
      spaceBetween: 20,
      navigation: {
        nextEl: nextEl,
        prevEl: prevEl,
      },
      pagination: {
        el: paginationEl,
        clickable: true,
      },
    });
  });
};

/**
 * Google Maps
 */
const initGoogleMaps = () => {
  const mapElements = document.querySelectorAll(".acf-map");
  if (!mapElements.length) return;

  const initMap = (el) => {
    const markers = el.querySelectorAll(".marker");
    const args = {
      zoom: parseInt(el.getAttribute("data-zoom")) || 16,
      center: { lat: 0, lng: 0 },
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    };

    const map = new google.maps.Map(el, args);
    map.markers = [];

    markers.forEach((markerEl) => {
      const lat = parseFloat(markerEl.getAttribute("data-lat"));
      const lng = parseFloat(markerEl.getAttribute("data-lng"));
      const latLng = { lat, lng };

      const marker = new google.maps.Marker({
        position: latLng,
        map: map,
      });

      map.markers.push(marker);

      if (markerEl.innerHTML.trim()) {
        const infowindow = new google.maps.InfoWindow({
          content: markerEl.innerHTML,
        });

        marker.addListener("click", () => {
          infowindow.open(map, marker);
        });
      }
    });

    centerMap(map);
  };

  const centerMap = (map) => {
    const bounds = new google.maps.LatLngBounds();
    map.markers.forEach((marker) => {
      bounds.extend(marker.position);
    });

    if (map.markers.length === 1) {
      map.setCenter(bounds.getCenter());
    } else {
      map.fitBounds(bounds);
    }
  };

  if (typeof google !== "undefined") {
    mapElements.forEach((el) => initMap(el));
  }
};

/**
 * Exhibitor Filters & Load More
 */
const initExhibitorFilters = () => {
  const categoryContainer = document.getElementById(
    "filter-category-container",
  );
  const searchInput = document.getElementById("filter-search");
  const searchBtn = document.getElementById("btn-search");
  const filterNew = document.getElementById("filter-new");
  const filterSpecial = document.getElementById("filter-special");
  const filterProductRelease = document.getElementById(
    "filter-product-release",
  );
  const alphaBtns = document.querySelectorAll(".civ-alpha-btn");
  const grid = document.getElementById("exhibitors-grid");
  const loadMoreBtn = document.getElementById("load-more-exhibitors");

  if (!grid || !window.civAjax) return;

  let currentPage = 1;
  let maxPages = loadMoreBtn ? parseInt(loadMoreBtn.dataset.maxPages) : 1;
  let isLoading = false;

  const resetBtn = document.getElementById("btn-reset-filters");

  let selectedCategories = [];

  if (categoryContainer) {
    const header = categoryContainer.querySelector(".civ-multiselect-header");
    const dropdown = categoryContainer.querySelector(
      ".civ-multiselect-dropdown",
    );
    const icon = categoryContainer.querySelector(".civ-multiselect-icon");
    const label = categoryContainer.querySelector(".civ-multiselect-label");
    const checkboxes = categoryContainer.querySelectorAll(
      ".civ-multiselect-checkbox",
    );

    const toggleDropdown = () => {
      dropdown.classList.toggle("hidden");
      icon.classList.toggle("-rotate-180");
    };

    const updateLabel = () => {
      selectedCategories = Array.from(checkboxes)
        .filter((cb) => cb.checked)
        .map((cb) => cb.value);

      if (selectedCategories.length === 0) {
        label.textContent = "All Categories";
        label.classList.remove("text-black", "font-bold");
      } else if (selectedCategories.length === 1) {
        const text = Array.from(checkboxes).find((cb) => cb.checked)
          .nextElementSibling.textContent;
        label.textContent = text;
        label.classList.add("text-black", "font-bold");
      } else {
        label.textContent = `${selectedCategories.length} Categories Selected`;
        label.classList.add("text-black", "font-bold");
      }
    };

    header.addEventListener("click", toggleDropdown);
    header.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        toggleDropdown();
      }
    });

    checkboxes.forEach((cb) => {
      cb.addEventListener("change", () => {
        updateLabel();
        fetchExhibitors(true);
      });
    });

    document.addEventListener("click", (e) => {
      if (
        !categoryContainer.contains(e.target) &&
        !dropdown.classList.contains("hidden")
      ) {
        dropdown.classList.add("hidden");
        icon.classList.remove("-rotate-180");
      }
    });
  }

  let selectedLetter = "";
  if (alphaBtns.length) {
    alphaBtns.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();

        // Toggle if currently selected
        if (btn.classList.contains("bg-civ-orange-500")) {
          btn.classList.remove(
            "bg-civ-orange-500",
            "text-white",
            "border-civ-orange-500",
          );
          btn.classList.add("bg-white", "text-gray-500", "border-gray-200");
          selectedLetter = "";
        } else {
          // Reset others
          alphaBtns.forEach((b) => {
            b.classList.remove(
              "bg-civ-orange-500",
              "text-white",
              "border-civ-orange-500",
            );
            b.classList.add("bg-white", "text-gray-500", "border-gray-200");
          });
          // Set active
          btn.classList.remove("bg-white", "text-gray-500", "border-gray-200");
          btn.classList.add(
            "bg-civ-orange-500",
            "text-white",
            "border-civ-orange-500",
          );
          selectedLetter = btn.getAttribute("data-letter");
        }

        fetchExhibitors(true);
      });
    });

    // Carousel Ribbon Interactions
    const track = document.getElementById("civ-alpha-track");
    const scrollLeftBtn = document.querySelector(".civ-alpha-scroll-left");
    const scrollRightBtn = document.querySelector(".civ-alpha-scroll-right");

    if (track && scrollLeftBtn && scrollRightBtn) {
      const scrollAmount = 250;

      const updateArrows = () => {
        // Evaluate if track overflows its container width
        if (track.scrollWidth > track.clientWidth) {
          scrollLeftBtn.style.display = "flex";
          scrollRightBtn.style.display = "flex";

          scrollLeftBtn.disabled = track.scrollLeft <= 5;
          scrollRightBtn.disabled =
            track.scrollLeft >= track.scrollWidth - track.clientWidth - 5;
        } else {
          // Disable completely if no overflow exists visually
          scrollLeftBtn.style.display = "none";
          scrollRightBtn.style.display = "none";
        }
      };

      scrollLeftBtn.addEventListener("click", () => {
        track.scrollBy({ left: -scrollAmount, behavior: "smooth" });
      });

      scrollRightBtn.addEventListener("click", () => {
        track.scrollBy({ left: scrollAmount, behavior: "smooth" });
      });

      track.addEventListener("scroll", updateArrows);
      window.addEventListener("resize", updateArrows);

      // Init arrows timeout
      setTimeout(updateArrows, 150);
    }
  }

  const checkFiltersState = () => {
    if (!resetBtn) return;
    const hasFilter =
      selectedCategories.length > 0 ||
      (searchInput && searchInput.value !== "") ||
      (filterNew && filterNew.checked) ||
      (filterSpecial && filterSpecial.checked) ||
      (filterProductRelease && filterProductRelease.checked) ||
      selectedLetter !== "";

    if (hasFilter) {
      resetBtn.classList.remove("hidden");
    } else {
      resetBtn.classList.add("hidden");
    }
  };

  const fetchExhibitors = (reset = false) => {
    checkFiltersState();
    if (isLoading) return;
    isLoading = true;

    if (reset) {
      currentPage = 0;
      grid.style.opacity = "0.5";
      grid.style.transition = "opacity 0.2s";
    }

    const formData = new FormData();
    formData.append("action", "civ_load_more_exhibitors");
    formData.append("nonce", window.civAjax.nonce);
    formData.append("page", reset ? 0 : currentPage);
    formData.append("category", selectedCategories.join(","));
    formData.append("search", searchInput ? searchInput.value : "");
    formData.append(
      "is_new",
      filterNew && filterNew.checked ? "true" : "false",
    );
    formData.append(
      "has_special",
      filterSpecial && filterSpecial.checked ? "true" : "false",
    );
    formData.append(
      "is_product_release",
      filterProductRelease && filterProductRelease.checked ? "true" : "false",
    );
    formData.append("letter", selectedLetter);
    formData.append("shows", grid ? grid.getAttribute("data-shows") : "");

    if (loadMoreBtn) {
      loadMoreBtn.textContent = "Loading...";
      loadMoreBtn.disabled = true;
    }

    fetch(window.civAjax.url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          if (reset) {
            grid.innerHTML = data.data.html;
            if (!data.data.html.trim()) {
              grid.innerHTML =
                '<div class="col-span-full text-center py-12 text-gray-500"><p class="text-xl">No exhibitors found.</p></div>';
            }
            currentPage = 1;
          } else {
            grid.insertAdjacentHTML("beforeend", data.data.html);
            currentPage++;
          }

          maxPages = data.data.max_pages;

          if (loadMoreBtn) {
            loadMoreBtn.textContent = "Load More";
            loadMoreBtn.disabled = false;

            if (currentPage >= maxPages) {
              loadMoreBtn.style.display = "none";
            } else {
              loadMoreBtn.style.display = "inline-block";
            }
          }
        }
      })
      .catch((err) => console.error(err))
      .finally(() => {
        isLoading = false;
        grid.style.opacity = "1";
      });
  };

  // Event Listeners

  if (searchBtn && searchInput) {
    searchBtn.addEventListener("click", () => fetchExhibitors(true));
    searchInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") fetchExhibitors(true);
    });
  }

  if (filterNew) {
    filterNew.addEventListener("change", () => fetchExhibitors(true));
  }

  if (filterSpecial) {
    filterSpecial.addEventListener("change", () => fetchExhibitors(true));
  }

  if (filterProductRelease) {
    filterProductRelease.addEventListener("change", () =>
      fetchExhibitors(true),
    );
  }

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", () => fetchExhibitors(false));
  }

  if (resetBtn) {
    resetBtn.addEventListener("click", () => {
      if (categoryContainer) {
        const checkboxes = categoryContainer.querySelectorAll(
          ".civ-multiselect-checkbox",
        );
        checkboxes.forEach((cb) => (cb.checked = false));
        selectedCategories = [];
        const label = categoryContainer.querySelector(".civ-multiselect-label");
        if (label) {
          label.textContent = "All Categories";
          label.classList.remove("text-black", "font-bold");
        }
      }
      if (searchInput) searchInput.value = "";
      if (filterNew) filterNew.checked = false;
      if (filterSpecial) filterSpecial.checked = false;
      if (filterProductRelease) filterProductRelease.checked = false;

      selectedLetter = "";
      alphaBtns.forEach((b) => {
        b.classList.remove(
          "bg-civ-orange-500",
          "text-white",
          "border-civ-orange-500",
        );
        b.classList.add("bg-white", "text-gray-500", "border-gray-200");
      });

      fetchExhibitors(true);
      checkFiltersState();
    });
  }
};

/**
 * Logo Carousel
 */
const initLogoCarousel = () => {
  const sliders = document.querySelectorAll(".logo-carousel-slider");
  if (!sliders.length) return;

  sliders.forEach((slider) => {
    let conf = {
      spdefault: 2,
      spmd: 3,
      splg: 4,
      spxl: 5,
      sp2xl: 6,
      autoplay: true,
      delay: 6000,
    };
    try {
      const configData = slider.getAttribute("data-config");
      if (configData) {
        conf = Object.assign(conf, JSON.parse(configData));
      }
    } catch (e) {
      console.error(e);
    }

    let swiperOpts = {
      loop: true,
      watchOverflow: true,
      pagination: {
        el: slider.querySelector(".logo-carousel-pagination"),
        clickable: true,
      },
      slidesPerView: conf.spdefault,
      breakpoints: {
        768: { slidesPerView: conf.spmd },
        1024: { slidesPerView: conf.splg },
        1280: { slidesPerView: conf.spxl },
        1536: { slidesPerView: conf.sp2xl },
      },
    };

    if (conf.autoplay) {
      swiperOpts.autoplay = {
        delay: conf.delay,
        disableOnInteraction: false,
      };
    } else {
      swiperOpts.autoplay = false;
    }

    new Swiper(slider, swiperOpts);
  });
};

/**
 * Stats Slider
 */
const initStatsSlider = () => {
  const statsSliders = document.querySelectorAll(".stats-slider");
  if (!statsSliders.length) return;

  statsSliders.forEach((elm) => {
    new Swiper(elm, {
      loop: true,
      pagination: {
        el: elm.querySelector(".swiper-pagination"),
        clickable: true,
      },
      navigation: {
        nextEl: elm.querySelector(".swiper-button-next"),
        prevEl: elm.querySelector(".swiper-button-prev"),
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 0,
          slidesPerGroup: 3,
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 0,
          slidesPerGroup: 4,
        },
      },
    });
  });

  // Stats Counter Animation
  const counters = document.querySelectorAll(".js-counter");
  const counterObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const counter = entry.target;
          const target = parseFloat(counter.getAttribute("data-target"));

          if (!isNaN(target)) {
            const duration = 2000; // 2 seconds
            const startTime = performance.now();

            const updateCounter = (currentTime) => {
              const elapsed = currentTime - startTime;
              const progress = Math.min(elapsed / duration, 1);

              // Ease-out cubic
              const ease = 1 - Math.pow(1 - progress, 3);

              const current = Math.floor(ease * target);
              counter.innerText = current.toLocaleString("en-AU");

              if (progress < 1) {
                requestAnimationFrame(updateCounter);
              } else {
                counter.innerText = target.toLocaleString("en-AU");
              }
            };

            requestAnimationFrame(updateCounter);
          }

          observer.unobserve(counter);
        }
      });
    },
    {
      threshold: 0.5,
    },
  );

  counters.forEach((counter) => counterObserver.observe(counter));
};

/**
 * Navigation & Header Logic
 */
const initNavigation = () => {
  const header = document.getElementById("site-header");
  const topbar = document.getElementById("topbar");
  const mainHeader = document.getElementById("main-header");
  const logoContainer = document.getElementById("logo-container");
  const headerInner = document.getElementById("header-inner");
  const mainNavWrapper = document.getElementById("main-nav-wrapper");

  // --- 1. Scroll Effect ---
  const handleScroll = () => {
    if (window.scrollY > 50) {
      // Scrolled State
      topbar.style.height = "0.5rem"; // Shrink topbar
      mainHeader.classList.remove("bg-transparent");
      mainHeader.classList.add("bg-black/80", "backdrop-blur-sm", "shadow-md");

      logoContainer.classList.remove(
        "w-20",
        "h-20",
        "md:w-32",
        "md:h-32",
        "2xl:w-40",
        "2xl:h-40",
      );
      logoContainer.classList.add(
        "w-16",
        "h-16",
        "md:w-20",
        "md:h-20",
        "lg:w-24",
        "lg:h-24",
      );

      headerInner.classList.remove("md:py-4", "xl:py-6");
      //headerInner.classList.add();

      mainNavWrapper.classList.remove(
        "lg:-translate-y-1/2",
        "lg:border-b",
        "lg:border-white/20",
      );
    } else {
      // Original State
      topbar.style.height = ""; // Revert to CSS default (h-10)
      mainHeader.classList.add("bg-transparent");
      mainHeader.classList.remove(
        "bg-black/90",
        "backdrop-blur-sm",
        "shadow-md",
      );

      logoContainer.classList.add(
        "w-20",
        "h-20",
        "md:w-32",
        "md:h-32",
        "2xl:w-40",
        "2xl:h-40",
      );
      logoContainer.classList.remove(
        "w-16",
        "h-16",
        "md:w-20",
        "md:h-20",
        "lg:w-24",
        "lg:h-24",
      );

      headerInner.classList.add("md:py-4", "xl:py-6");
      //headerInner.classList.remove();

      mainNavWrapper.classList.add(
        "lg:-translate-y-1/2",
        "lg:border-b",
        "lg:border-white/20",
      );
    }
  };

  window.addEventListener("scroll", handleScroll);
  handleScroll();

  // --- 2. Mega Menu Hover Logic ---
  const megaLinks = document.querySelectorAll(".megamenu-link");
  megaLinks.forEach((link) => {
    link.addEventListener("mouseenter", () => {
      const targetId = link.getAttribute("data-target");
      const targetContent = document.getElementById(targetId);
      if (targetContent) {
        const parentContainer = link
          .closest(".grid")
          .querySelector(".col-span-5");
        const siblingContents =
          parentContainer.querySelectorAll(".megamenu-content");
        siblingContents.forEach((c) => c.classList.add("hidden"));
        targetContent.classList.remove("hidden");

        const siblingLinks = link
          .closest("ul")
          .querySelectorAll(".megamenu-link");
        siblingLinks.forEach((l) => l.classList.remove("text-civ-orange-500"));
        link.classList.add("text-civ-orange-500");
      }
    });
  });

  // --- 3. Mobile Menu Toggle ---
  const mobileToggle = document.getElementById("mobile-menu-toggle");
  const mobileClose = document.getElementById("mobile-menu-close");
  const mobileDrawer = document.getElementById("mobile-menu-drawer");
  const mobileBackdrop = document.getElementById("mobile-menu-backdrop");
  const mobileContent = document.getElementById("mobile-menu-content");
  const submenuToggles = document.querySelectorAll(".mobile-submenu-toggle");

  const openMobileMenu = () => {
    mobileDrawer.classList.remove("invisible");
    mobileDrawer.classList.add("visible");
    mobileBackdrop.classList.add("opacity-100");
    mobileContent.classList.remove("translate-x-full");
    document.body.classList.add("overflow-hidden");
  };

  const closeMobileMenu = () => {
    mobileBackdrop.classList.remove("opacity-100");
    mobileContent.classList.add("translate-x-full");
    document.body.classList.remove("overflow-hidden");
    setTimeout(() => {
      mobileDrawer.classList.remove("visible");
      mobileDrawer.classList.add("invisible");
    }, 300);
  };

  if (mobileToggle) mobileToggle.addEventListener("click", openMobileMenu);
  if (mobileClose) mobileClose.addEventListener("click", closeMobileMenu);
  if (mobileBackdrop) mobileBackdrop.addEventListener("click", closeMobileMenu);

  // --- 4. Mobile Submenu Accordion ---
  submenuToggles.forEach((toggle) => {
    toggle.addEventListener("click", (e) => {
      e.preventDefault();
      const parent = toggle.closest(".mobile-menu-item-wrapper");
      const submenu = parent.querySelector(".mobile-submenu");
      const icon = toggle.querySelector("svg");

      if (submenu.classList.contains("hidden")) {
        submenu.classList.remove("hidden");
        icon.classList.add("rotate-180");
      } else {
        submenu.classList.add("hidden");
        icon.classList.remove("rotate-180");
      }
    });
  });

  // --- 5. Search Toggle Logic ---
  const searchToggleBtn = document.getElementById("nav-search-toggle");
  const searchForm = document.getElementById("nav-search-form");
  const searchCloseBtn = document.getElementById("nav-search-close");

  const openSearch = (e) => {
    e.preventDefault();
    searchForm.classList.remove("w-0", "opacity-0", "invisible");
    searchForm.classList.add("w-[300px]", "opacity-100", "visible");
    setTimeout(() => {
      searchForm.querySelector("input").focus();
    }, 300);
  };

  const closeSearch = () => {
    searchForm.classList.remove("w-[300px]", "opacity-100", "visible");
    searchForm.classList.add("w-0", "opacity-0", "invisible");
    searchForm.querySelector("input").blur();
  };

  if (searchToggleBtn) searchToggleBtn.addEventListener("click", openSearch);
  if (searchCloseBtn) searchCloseBtn.addEventListener("click", closeSearch);

  document.addEventListener("click", (e) => {
    if (searchForm && !searchForm.classList.contains("invisible")) {
      if (
        !searchForm.contains(e.target) &&
        !searchToggleBtn.contains(e.target)
      ) {
        closeSearch();
      }
    }
  });
};

const initPostsPagination = () => {
  document.addEventListener("click", function (e) {
    const link = e.target.closest(".posts-pagination a.page-numbers");
    if (!link) return;

    e.preventDefault();
    const paginationContainer = link.closest(".posts-pagination");
    if (!paginationContainer) return;

    const targetSelector = paginationContainer.getAttribute("data-target");
    const targetContainer = document.querySelector(targetSelector);
    if (!targetContainer) return;

    // Extract page number from href. URL formats: ?paged=2 or /page/2/
    const href = link.getAttribute("href");
    let page = 1;
    let pageMatch = href.match(/\/page\/(\d+)/);
    if (pageMatch) {
      page = parseInt(pageMatch[1], 10);
    } else {
      const url = new URL(href, window.location.origin);
      if (url.searchParams.has("paged")) {
        page = parseInt(url.searchParams.get("paged"), 10);
      } else if (url.searchParams.has("page")) {
        page = parseInt(url.searchParams.get("page"), 10);
      }
    }

    const categories = targetContainer.getAttribute("data-categories");
    const ppp = targetContainer.getAttribute("data-ppp");

    // Prevent multiple clicks
    if (paginationContainer.classList.contains("opacity-50")) return;

    paginationContainer.classList.add("opacity-50", "pointer-events-none");
    targetContainer.classList.add("opacity-50");

    const formData = new FormData();
    formData.append("action", "civ_load_more_posts");
    formData.append("nonce", window.civAjax.posts_nonce);
    formData.append("page", page);
    formData.append("posts_per_page", ppp);
    formData.append("categories", categories);
    formData.append("current_url", window.location.href);

    // Extract just the ID from the targetSelector (e.g. from "#posts-list... .posts-grid" to "posts-list...")
    const targetIdMatch = targetSelector.match(/#([^\s]+)/);
    const targetId = targetIdMatch ? targetIdMatch[1] : "";
    formData.append("target_id", targetId);

    fetch(window.civAjax.url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((res) => {
        if (res.success && res.data.html) {
          // REPLACE items instead of appending
          targetContainer.innerHTML = res.data.html;

          // Update pagination HTML
          if (res.data.pagination) {
            paginationContainer.innerHTML = res.data.pagination;
          }

          // Scroll smoothly to the top of the target container minus header padding
          const yOffset = -120; // 120px offset for fixed header
          const y =
            targetContainer.getBoundingClientRect().top +
            window.scrollY +
            yOffset;
          window.scrollTo({ top: y, behavior: "smooth" });
        }
      })
      .catch((error) => {
        console.error("Error loading posts:", error);
      })
      .finally(() => {
        paginationContainer.classList.remove(
          "opacity-50",
          "pointer-events-none",
        );
        targetContainer.classList.remove("opacity-50");
      });
  });
};

document.addEventListener("DOMContentLoaded", () => {
  initNavigation();
  initHomeHero();
  initInteractiveSelect();
  initExhibitorSpecial();
  initMediaSlider();
  initGoogleMaps();
  initExhibitorFilters();
  initLogoCarousel();
  initPostsPagination();
  initStatsSlider();

  // Fancybox initialization
  Fancybox.bind("[data-fancybox]", {
    // Basic Options
    //groupAll: true, // Group all items with the same data-fancybox name
    Thumbs: false, // Hide the thumbnail strip (per your screenshot)
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

console.log("CIV Shows Theme Loaded");
