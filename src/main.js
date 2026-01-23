import './style.css';
import Swiper from 'swiper/bundle';

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
    //effect: "fade",
    //fadeEffect: {
//      crossFade: true
  //  },
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
      // 1. When a new slide starts (manually or auto), flip the direction
      slideChangeTransitionStart: function() {
        isGrowPhase = !isGrowPhase;
      },

      // 2. Animate based on the current Phase
      autoplayTimeLeft(s, time, progress) {
        if (!progressBar) return;

        if (isGrowPhase) {
          // == GROW DOWN PHASE ==
          // Bar starts at Top, Height 0% -> 100%
          progressBar.style.bottom = "auto";
          progressBar.style.top = "0";
          progressBar.style.height = ((1 - progress) * 100) + "%";

        } else {
          // == SHRINK DOWN PHASE ==
          // Bar starts at Bottom, Height 100% -> 0%
          // (Visually looks like the top edge is moving down)
          progressBar.style.top = "auto";
          progressBar.style.bottom = "0";
          progressBar.style.height = (progress * 100) + "%";
        }
      },
      
      // 3. Reset visual state immediately on change to prevent glitches
      slideChange() {
         if (!progressBar) return;
         // If we are about to Grow, ensure we start at 0
         if (isGrowPhase) {
           progressBar.style.top = "0";
           progressBar.style.bottom = "auto";
           progressBar.style.height = "0%";
         } else {
           // If we are about to Shrink, ensure we start at 100
           progressBar.style.top = "auto";
           progressBar.style.bottom = "0";
           progressBar.style.height = "100%";
         }
      }
    }
  });
};

document.addEventListener('DOMContentLoaded', initHomeHero);
console.log('CIV Shows Theme Loaded');
