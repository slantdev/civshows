<?php

/**
 * Component: Page Header
 */

$event_id = Tribe__Events__Main::postIdHelper(get_the_ID());
?>

<section class="civ-page-header w-full relative bg-cover bg-no-repeat bg-civ-blue-500 text-white">

  <div class="civ-page-header-content container mx-auto px-4 md:px-6 lg:px-8 pt-40 pb-10 md:pt-52 xl:pb-16 xl:px-8 xl:pt-72 relative z-10">
    <div class="flex flex-col lg:flex-row items-end justify-between gap-6 lg:gap-10 2xl:gap-12">
      <div class="w-full lg:w-3/5 2xl:w-1/2">
        <h1 class="civ-page-header-title text-4xl md:text-5xl 2xl:text-6xl font-semibold leading-tight">
          <?php echo get_the_title(); ?>
        </h1>
      </div>
    </div>

    <?php echo tribe_events_event_schedule_details($event_id, '<div>', '</div>'); // phpcs:ignore StellarWP.XSS.EscapeOutput.OutputNotEscaped 
    ?>

    <div class="civ-page-header-breadcrumbs flex">
      <div class="w-full lg:w-3/5 2xl:w-1/2">
        <div class="h-0.25 w-full bg-white/40 my-6"></div>
        <nav class="text-sm md:text-base font-medium opacity-90">
          <ul class="flex items-center space-x-2">
            <li><a href="<?php echo home_url(); ?>" class="civ-page-header-breadcrumb-link hover:underline">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo esc_url(tribe_get_events_link()); ?>" class="civ-page-header-breadcrumb-link hover:underline">Events</a></li>
            <li>/</li>
            <li><span class="font-bold"><?php echo get_the_title(); ?></span></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>

</section>