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

        $fields = self::SetFields($slider_selector);
        if( !$fields["slides"] || empty($fields["slides"]) ) return;

        self::Html($fields);
        self::JavaScript($fields);
        
    }


    public static function SetFields(object $slider_selector): ?array 
    {
        if ( ! $slider_selector ) return null;

        $fields = [
            "slider_selector_id" => $slider_selector->ID,
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
            "slides" => get_field('slide', $slider_selector->ID)
        ];

        return $fields;
    }


    public static function Html($fields): void
    {
        
        include_once 'print-slide.php';
        $unique_id = $fields["slider_selector_id"];

        echo "<div class='swiper swiper" . $unique_id . "'>";
        echo "<div class='swiper-wrapper'>";

        foreach( $fields["slides"] as $slide ) {
            new PrintSlide($slide);
        }
        echo "</div>";

        

        if($fields["pagination"]) {
            echo "<div class='swiper-pagination swiper-pagination{$unique_id}'></div>";
        } 
        if($fields["navigation"]) {
            echo "<div class='swiper-button-prev swiper-button-prev{$unique_id}'></div>";
            echo "<div class='swiper-button-next swiper-button-next{$unique_id}'></div>";
        }
        if($fields["scrollbar"]) {
            echo "<div class='swiper-scrollbar swiper-scrollbar{$unique_id}'></div>";
        }
        echo "</div>";

    }


    public static function JavaScript($fields): void
    {
        $unique_id = $fields["slider_selector_id"];

        echo "<script defer>";
        echo "new Swiper('.swiper{$unique_id}', {";
        echo "direction: 'horizontal',";
        echo "loop: true,";

        if($fields["pagination"]) {
            echo "pagination: {";
            echo "el: '.swiper-pagination{$unique_id}',";
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

