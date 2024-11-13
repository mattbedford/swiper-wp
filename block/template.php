<?php

namespace SwiperWP;


class BlockBuild 
{
	
    public static function BuildSliderBlock($block) 
    {
        $slider_selector = get_post($block['data']['slider-selector']);

        if ( ! $slider_selector ) {
            return;
        }

		$slide_type = strtolower(get_field('slider_type', $slider_selector->ID));
		if(!method_exists(BlockBuild::class, $slide_type)) return;
		
		$fields = self::$slide_type($slider_selector);				
        if( !$fields["slides"] || empty($fields["slides"]) ) return;

        // Polymorphism that could be any of "news", "logos", "hero", "products" or "partners"
        $command = "Html" . ucfirst($slide_type);
        $filename = $command . ".php";
        include_once $filename;


        $slides_object = new $command($fields);
        self::Html($slides_object);
    }

    public static function Html(object $slides_object): void
    {

        $unique_id = $fields["slider_selector_id"];
        echo "<div class='swiper swiper" . $unique_id . "' data-slider-type='" . $slider_type . "'>";
        echo "<div class='swiper-wrapper'>";

        echo $slides_object->html;

        echo "</div>";
        echo "</div>";

        self::Js($slides_object);

    }

    public static function Js(object $slides_object): void { ?>

        <script defer>

            var swiper<?php echo $unique_id; ?> = new Swiper('.swiper<?php echo $unique_id; ?>', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true});

            <?php if($slides_object->fields['pagination']) { ?>
                swiper<?php echo $unique_id; ?>.pagination.el = '.swiper-pagination<?php echo $unique_id; ?>';
                swiper<?php echo $unique_id; ?>.pagination.clickable = true;
            <?php } ?>

            <?php if($slides_object->fields['navigation']) { ?>
                swiper<?php echo $unique_id; ?>.navigation.nextEl = '.swiper-button-next<?php echo $unique_id; ?>';
                swiper<?php echo $unique_id; ?>.navigation.prevEl = '.swiper-button-prev<?php echo $unique_id; ?>';
            <?php } ?>

            <?php if($slides_object->fields['scrollbar']) { ?>
                swiper<?php echo $unique_id; ?>.scrollbar.el = '.swiper-scrollbar<?php echo $unique_id; ?>';
            <?php } ?>

            </script>

   <?php }

}


