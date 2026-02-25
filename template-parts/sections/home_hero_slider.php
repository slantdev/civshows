<?php
include get_template_directory() . '/template-parts/global/section-settings.php';
/*
 * Available section variables (from section-settings.php):
 * $section_id
 * $section_style
 * $section_container_class
 * $section_overlay_markup
 */

// Generate stable ID if not set
if (!$section_id) {
  static $home_hero_count = 0;
  $home_hero_count++;
  $section_id = 'section-home-hero-' . get_the_ID() . '-' . $home_hero_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';

// Data
$hero_group = get_sub_field('home_hero_slider');
$slides = $hero_group['home_slider'] ?? [];

if (empty($slides)) return;
?>

<section <?php echo $section_id_attr; ?> class="relative w-full h-[600px] lg:h-[800px] xl:h-svh bg-civ-blue-950 overflow-hidden group section-home-hero-slider" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="absolute left-0 h-full w-2 bg-black/50 z-30"></div>
  <div id="hero-progress-bar" class="absolute left-0 w-2 z-30 bg-civ-orange-500"></div>

  <div class="swiper main-slider w-full h-full">
    <div class="swiper-wrapper">
      <?php foreach ($slides as $slide) :
        $content = $slide['content'] ?? [];
        $title = $content['title'] ?? '';
        $description = $content['description'] ?? '';
        $button = $content['button'] ?? [];
        $bg_group = $slide['background_image'] ?? [];
        $bg_image = $bg_group['background_image']['url'] ?? '';
        $bg_overlay = $bg_group['background_overlay'] ?? 'rgba(0,0,0,0.6)';
      ?>
        <div class="swiper-slide relative flex items-center justify-center xl:pt-64">
          <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url($bg_image); ?>');">
            <div class="absolute inset-0" style="background-color: <?php echo esc_attr($bg_overlay); ?>;"></div>
          </div>
          <div class="container mx-auto px-4 xl:px-8 relative z-10 grid grid-cols-1 md:grid-cols-12 h-full items-center">
            <div class="hidden md:block md:col-span-4 xl:col-span-5"></div>
            <div class="col-span-1 md:col-span-8 xl:col-span-7 text-white md:pl-16">
              <?php if ($title) : ?>
                <h1 class="text-4xl md:text-6xl font-bold mb-4" data-swiper-parallax="-400"><?php echo esc_html($title); ?></h1>
              <?php endif; ?>

              <?php if ($description) : ?>
                <p class="text-lg md:text-xl mb-8 max-w-2xl font-light" data-swiper-parallax="-700">
                  <?php echo wp_kses_post($description); ?>
                </p>
              <?php endif; ?>

              <?php
              // Handle Button
              if (!empty($button)) {
                get_template_part('template-parts/components/button', '', [
                  'field' => $button,
                  'class' => 'py-4 px-10 uppercase tracking-widest transition-all hover:scale-105 text-sm',
                  'attributes' => [
                    'data-swiper-parallax' => '-1000'
                  ]
                ]);
              }
              ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Thumbs Vertical Navigation -->
  <div class="absolute top-0 bottom-0 left-0 z-20 container mx-auto px-4 xl:px-8 xl:pt-64 pointer-events-none">
    <div class="h-full grid grid-cols-1 md:grid-cols-12 items-center">
      <div class="hidden md:flex md:col-span-4 lg:col-span-4 flex-col justify-center h-full pointer-events-auto pl-6">
        <div class="swiper thumbs-slider w-full max-w-96 overflow-visible!">
          <div class="swiper-wrapper flex-col">
            <?php foreach ($slides as $slide) :
              $content = $slide['content'] ?? [];
              $title = $content['title'] ?? '';
              $description = $content['description'] ?? '';
            ?>
              <div class="swiper-slide h-auto! cursor-pointer transition-all duration-300">
                <div class="slide-thumb-wrapper p-6 relative transition-all duration-300">
                  <div class="slide-thumb-indicator h-[3px]"></div>
                  <div class="pt-3">
                    <h3 class="text-white font-bold text-xl mb-2"><?php echo esc_html($title); ?></h3>
                    <div class="text-gray-200 text-sm leading-relaxed font-light line-clamp-3">
                      <?php echo wp_kses_post($description); ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>