<?php

namespace SwiperWP;

class HtmlLogos {

    private $fields = [];
    public $html = "";

    public function __construct(object $slider_selector)
    {

        include_once 'print-slide.php';
        $this->fields = [
            "slider_selector_id" => $slider_selector->ID,
            "slider_type" => get_field('slider_type', $slider_selector->ID),
            "pagination" => get_field('enable_pagination', $slider_selector->ID),
            "navigation" => get_field('enable_nav', $slider_selector->ID),
            "scrollbar" => get_field('enable_scrollbar', $slider_selector->ID),
        ];

        $this->Html();
    }


    private function Html() {
        $this->fields['slides'] = get_terms([
            'taxonomy' => 'produttore',
            'parent'   => 0,
            'limit' => -1,
            'order' => 'ASC',
            'orderby' => 'name'
        ]);

        $slider_type = strval($this->fields["slider_type"]);

        foreach( $this->fields["slides"] as $slide ) {
            $printer = new PrintSlide();
            $this->html .= $printer->$slider_type($slide);
        }
    }

}