<?php

namespace SwiperWP;


class BlockBuild 
{
	
	public static $number_of_slides = 0;

	
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
		
        self::Html($fields, $slide_type);
		
        self::JavaScript($fields);
        
    }


    public static function hero(object $slider_selector): ?array 
    {
        if ( ! $slider_selector ) return null;

		$fields = [];
        $fields = [
            "slider_selector_id" => $slider_selector->ID,
			"slider_type" => get_field('slider_type', $slider_selector->ID),
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
            "slides" => get_field('slide', $slider_selector->ID) ?? null,
        ];
		self::$number_of_slides = count($fields["slides"]) ?? 0;
        return $fields;
    }
	
	
	public static function partners(object $slider_selector): ?array 
    {
        if ( ! $slider_selector ) return null;

        $fields = [
            "slider_selector_id" => $slider_selector->ID,
			"slider_type" => get_field('slider_type', $slider_selector->ID),
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
            "slides" => [1,2], // Non empty array
        ];
		
        return $fields;
    }
	
	
	public static function logos(object $slider_selector): ?array 
    {
        if ( ! $slider_selector ) return null;

        $fields = [
            "slider_selector_id" => $slider_selector->ID,
			"slider_type" => get_field('slider_type', $slider_selector->ID),
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
            "slides" => get_field('slide', $slider_selector->ID) ?? null,
        ];
		
        return $fields;
    }
	
	
	public static function news(object $slider_selector): ?array 
    {
        if ( ! $slider_selector ) return null;

        $fields = [
            "slider_selector_id" => $slider_selector->ID,
			"slider_type" => get_field('slider_type', $slider_selector->ID),
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
            "slides" => [1,2],
        ];
		
        return $fields;
    }
	
	
	public static function products(object $slider_selector): ?array 
    {
        if ( ! $slider_selector ) return null;
		$fields = [];
        $fields = [
            "slider_selector_id" => $slider_selector->ID,
			"slider_type" => get_field('slider_type', $slider_selector->ID),
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
            "slides" => [1,2],
        ];
		
        return $fields;
    }
	


    public static function Html($fields, $slider_type): void
    {
		
		if("news" === $slider_type) {
			$fields['slides'] = get_posts([
			"post_type" => "post",
			"numberposts" => 8,
			]); 
			self::$number_of_slides = count($fields['slides']) ?? 0;
		}
		
		if("products" === $slider_type && is_product()) {
			$product_id = get_the_ID();
			$fields['slides'] = wc_get_related_products($product_id, 8, []);
			self::$number_of_slides = count($fields['slides']) ?? 0;
		}
		
		if("partners" === $slider_type || "logos" === $slider_type) {
			$fields['slides'] = get_terms([ 
			'taxonomy' => 'produttore',
			'parent'   => 0,
			'limit' => -1,
			'order' => 'ASC',
			'orderby' => 'name'
			]);
			self::$number_of_slides = count($fields['slides']) ?? 0;
		}
			
        include_once 'print-slide.php';
        $unique_id = $fields["slider_selector_id"];

        echo "<div class='swiper swiper" . $unique_id . "' data-slider-type='" . $slider_type . "'>";
        echo "<div class='swiper-wrapper'>";
		
        foreach( $fields["slides"] as $slide ) {
			$printer = new PrintSlide();
			$printer->$slider_type($slide);
        }
        echo "</div>";

        

        if($fields["pagination"]) {
            echo "<div class='swiper-pagination swiper-pagination{$unique_id}'></div>";
        } 
        if($fields["navigation"]) {
            echo "<div class='nav-wrap-prev'><div class='swiper-button-prev swiper-button-prev{$unique_id}'>";
			echo '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="20" fill="none">
  <path fill="#03597E" d="M10.73 19.6a1.34 1.34 0 0 0 0-1.89L4.6 11.57h22.08c.73 0 1.33-.6 1.33-1.33 0-.74-.6-1.34-1.33-1.34H4.62l6.11-6.1c.51-.51.51-1.36 0-1.88a1.34 1.34 0 0 0-1.88 0L.36 9.41a1.17 1.17 0 0 0 0 1.7l8.48 8.5a1.34 1.34 0 0 0 1.9 0Z"/>
</svg>';			
			echo "</div></div>";
            echo "<div class='nav-wrap-next'><div class='swiper-button-next swiper-button-next{$unique_id}'>";
			echo '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="20" fill="none">
  <path fill="#03597E" d="M17.27.4a1.34 1.34 0 0 0 0 1.89l6.14 6.14H1.33C.6 8.43 0 9.03 0 9.76c0 .74.6 1.34 1.33 1.34h22.05l-6.11 6.1a1.34 1.34 0 0 0 0 1.88c.52.51 1.36.51 1.88 0l8.49-8.49a1.17 1.17 0 0 0 0-1.7L19.16.4a1.34 1.34 0 0 0-1.9 0Z"/>
</svg> ';		
			echo "</div></div>";
        }
        if($fields["scrollbar"]) {
            echo "<div class='swiper-scrollbar swiper-scrollbar{$unique_id}'></div>";
        }
        echo "</div>";

    }
	

    public static function JavaScript($fields): void
    {
		
		$count = self::$number_of_slides;
		if($count <= 0) return;

		$unique_id = $fields["slider_selector_id"];

        echo "<script defer>";
        echo "new Swiper('.swiper{$unique_id}', {";
        echo "direction: 'horizontal',";
        echo "loop: true,";
		echo "spaceBetween: 20,";
		
		// Other custom slide types can have own setup here
		if(strtolower($fields["slider_type"]) === 'hero') {			
			echo "autoplay: false,";
			echo "slidesPerView:1, slidesPerGroup: 1,"; // Default
			echo "breakpoints: {900: { navigation: {enabled:true} }, 320: { navigation: {enabled:false} } },";
		}
		/*PARTNERS*/
		if(strtolower($fields["slider_type"]) === 'partners') {
			$max_slides = 6;
			if($max_slides > $count) {
				while($max_slides > $count) $max_slides--;
			}
			$spg = intdiv($max_slides, 2);
			
			echo "autoplay: true,";
			echo "slidesPerView:{$max_slides}, slidesPerGroup: {$spg},"; // Default
			echo "breakpoints: {320: {slidesPerView:$spg,  slidesPerGroup: $spg,}, 900: {slidesPerView:{$max_slides},slidesPerGroup: {$spg},}},";
		}
		/*NEWS & EVENTS*/
		if(strtolower($fields["slider_type"]) === 'news') {
			$max_slides = 3.5;
			if($max_slides > $count) {
				while($max_slides > $count) $max_slides--;
			}
			
			$spg = 1;
			echo "autoplay: false,";
			echo "slidesPerView:{$max_slides}, slidesPerGroup: {$spg},"; // Default
			echo "breakpoints: {320: {slidesPerView:1.25,  slidesPerGroup: $spg,}, 900: {slidesPerView:{$max_slides},slidesPerGroup: {$spg},}},";
		}
		/*PRODUCTS*/
		if(strtolower($fields["slider_type"]) === 'products') {
			$max_slides = 4;
			$spg = 1;
			echo "autoplay: false,";
			echo "slidesPerView:{$max_slides}, slidesPerGroup: {$spg},"; // Default
			echo "breakpoints: {320: {slidesPerView:1.25,  slidesPerGroup: 1.25,}, 900: {slidesPerView:1.25,  slidesPerGroup: 1.25,}},";
		}

        if($fields["pagination"]) {
            echo "pagination: {";
            echo "el: '.swiper-pagination{$unique_id}',";
			echo "clickable: true,";
            echo "},";
        } 
        if($fields["navigation"]) {
            echo "navigation: {";
            echo "nextEl: '.swiper-button-next{$unique_id}',";
            echo "prevEl: '.swiper-button-prev{$unique_id}',";
            echo "},";
        }
        if($fields["scrollbar"]) {
            echo "scrollbar: {";
            echo "el: '.swiper-scrollbar{$unique_id}',";
            echo "},";
        }
        echo "});";
        echo "</script>";
    }

}


