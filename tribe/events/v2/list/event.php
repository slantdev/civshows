<?php
/**
 * View: List Event
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

$container_classes = [];
$container_classes['tribe-events-calendar-list__event-row--featured'] = $event->featured;

$event_classes = tribe_get_post_class( [ 'tribe-events-calendar-list__event', 'tribe-common-g-row', 'tribe-common-g-row--gutters' ], $event->ID );
?>

<li>

	<div class="bg-white border! border-gray-200! rounded-lg p-4! md:p-6! flex flex-col md:flex-row gap-6 md:gap-8 shadow-sm hover:shadow-md transition-shadow my-6! xl:my-8!">
		<div class="w-full md:w-1/3 shrink-0 relative rounded-md overflow-hidden aspect-video md:aspect-auto">
			<?php $this->template( 'list/event/featured-image', [ 'event' => $event ] ); ?>
			<div class="absolute bottom-0 left-4 bg-white text-civ-blue-600 font-bold text-[10px] sm:text-xs uppercase py-2! px-4! rounded-t-md">
				<?php $this->template( 'list/event/date', [ 'event' => $event ] ); ?>
			</div>
		</div>

		<div class="flex flex-col justify-center w-full">

			<?php $this->template( 'list/event/title', [ 'event' => $event ] ); ?>

			<?php $this->template( 'list/event/description', [ 'event' => $event ] ); ?>

			<div class="flex flex-wrap gap-3">
				<a
					href="<?php echo esc_url( $event->permalink ); ?>"
					title="<?php echo esc_attr( $event->title ); ?>"
					rel="bookmark"
					class="inline-block bg-civ-orange-500! hover:bg-civ-orange-600! text-white! font-bold! uppercase! text-xs! py-2! px-6! rounded-sm! transition-colors shadow-sm"
				>
				More Details
				</a>			
			</div>
		</div>
	</div>

</li>

