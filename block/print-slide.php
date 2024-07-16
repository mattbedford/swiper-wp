<?php


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