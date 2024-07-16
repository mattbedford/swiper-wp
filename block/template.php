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

$slider_selector_id = $slider_selector->ID;
$pagination = get_field('enable_pagination', $slider_selector_id);
$navigation = get_field('enable_nav', $slider_selector_id);
$scrollbar = get_field('enable_scrollbar', $slider_selector_id);
$slides = get_field('slide', $slider_selector_id);

if( !$slides ) return;

function print_slide($slide) {

    $headline = $slide['slide_headline'];
    $text = $slide['slide_text'];
    $background = $slide['slide_background_image'];
    $image = $slide['slide_image_content'];
    $link = $slide['slide_link'];

    echo "<div class='swiper-slide'>";
    	echo "<div class='slide-content' style='background-image: url($background)'>";
    		echo "<h2>$headline</h2>";
    		echo "<p>$text</p>";
    		echo "<a href='$link' class='btn'>Read more</a>";
    	echo "</div>";
	echo "</div>";
}

echo "<div class='swiper swiper" . $slider_selector_id . "'>";
echo "<div class='swiper-wrapper'>";

foreach( $slides as $slide ) {
    print_slide($slide);
}
echo "</div>";

if($pagination) {
    echo "<div class='swiper-pagination{$slider_selector_id}'></div>";
} 
if($navigation) {
    echo "<div class='swiper-button-prev{$slider_selector_id}'></div>";
    echo "<div class='swiper-button-next{$slider_selector_id}'></div>";
}
if($scrollbar) {
    echo "<div class='swiper-scrollbar{$slider_selector_id}'></div>";
}
echo "</div>";


?>

<script defer>


const x = new Swiper('<?php echo ".swiper" . $slider_selector_id; ?>', {
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
