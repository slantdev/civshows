<?php

/**
 * Component: CTA Promo
 */

?>

<section class="relative w-full min-h-[500px] lg:min-h-[600px] flex items-center justify-center overflow-hidden">

  <div class="absolute inset-0 w-full h-full">
    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/demo/caravan-subscribe.jpg' ?>" alt="Caravans in a scenic landscape" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black/50"></div>
  </div>

  <div class="container mx-auto px-4 sm:px-6 lg:px-8 md:px-8 relative z-10 max-w-6xl">
    <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-16 xl:gap-24">

      <div class="w-full md:w-1/3 flex justify-center md:justify-start">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/demo/gear-up-and-win.png' ?>" alt="Gear Up and Win. The more you spend the more entries you get." class="max-w-sm md:max-w-md w-full h-auto">
      </div>

      <div class="w-full md:w-2/3 text-white text-center md:text-left">
        <div class="prose prose-lg text-white">
          <h2 class="text-3xl md:text-4xl xl:text-[38px] text-white font-medium mb-6 leading-[1.1]">
            Turn Your Next Caravan Purchase, Service or Repair Into a Chance to Win
          </h2>
          <p class="text-lg mb-8 leading-relaxed opacity-90">
            Every time you buy, service, or repair your caravan or RV with a participating Caravan Industry Victoria member, you’re not just gearing up for your next adventure — you’re also scoring an entry into our massive $50,000 prize pool!
          </p>
          <a href="#" class="inline-block bg-civ-blue-500 hover:bg-civ-blue-600 text-white font-bold uppercase no-underline py-3 px-10 rounded-md transition-colors text-sm tracking-wider">
            Learn More
          </a>
        </div>
      </div>

    </div>
  </div>
</section>