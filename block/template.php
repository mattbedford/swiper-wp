<?php
/**
 * Block Name: Slider block template
 *
 * Description: Displays a list of posts.
 */
$slider_selector = get_post($block['data']['slider-selector']);

if ( ! $slider_selector ) {
    return;
}

include_once 'print-slide.php';

$slider_selector_id = $slider_selector->ID;
$pagination = get_field('enable_pagination', $slider_selector_id);
$navigation = get_field('enable_nav', $slider_selector_id);
$scrollbar = get_field('enable_scrollbar', $slider_selector_id);
$slides = get_field('slide', $slider_selector_id);

if( !$slides ) return;

echo "<div class='swiper swiper" . $slider_selector_id . "'>";
echo "<div class='swiper-wrapper'>";

foreach( $slides as $slide ) {
    print_slide($slide);
}
echo "</div>";

if($pagination) {
    echo "<div class='swiper-pagination swiper-pagination{$slider_selector_id}'></div>";
} 
if($navigation) {
    echo "<div class='swiper-button-prev swiper-button-prev{$slider_selector_id}'></div>";
    echo "<div class='swiper-button-next swiper-button-next{$slider_selector_id}'></div>";
}
if($scrollbar) {
    echo "<div class='swiper-scrollbar swiper-scrollbar{$slider_selector_id}'></div>";
}
echo "</div>";


?>

<script defer>


new Swiper('<?php echo ".swiper" . $slider_selector_id; ?>', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,
  <?php if($pagination) { ?>
    pagination: {
        el: '.swiper-pagination<?php echo $slider_selector_id; ?>',
    },
  <?php } ?>
  <?php if($navigation) { ?>
	navigation: {
		nextEl: '.swiper-button-next<?php echo $slider_selector_id; ?>',
		prevEl: '.swiper-button-prev<?php echo $slider_selector_id; ?>',
	},
    <?php } ?>
    <?php if($scrollbar) { ?>
	scrollbar: {
		el: '.swiper-scrollbar<?php echo $slider_selector_id; ?>',
	},
    <?php } ?>
});

</script>
