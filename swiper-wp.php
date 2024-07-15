<?php


namespace SwiperWP;


class Register {

  public function __construct() {

    add_action('init', [self::class, 'register_slider_block']);
    add_action('wp_enqueue_scripts', [self::class, 'CheckForSwiper']);
      
  }
  
  
  public static function CheckForSwiper (): void
  {
  	
    if ( strpos( get_the_content(), 'swiper' ) !== false || is_page("swiper")) {
        wp_register_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            [],
            false,
            false
        );
       wp_register_script(
            'swiper-config',
            get_stylesheet_directory_uri() . '/js/swiper-config.js',
            ['swiper-js'],
            false,
            true
        );
       wp_register_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
       wp_enqueue_script('swiper-js');
       wp_enqueue_style('swiper-css');
       wp_enqueue_script('swiper-config');
    } 
  }


    public static function register_slider_block() {
		
      register_block_type( dirname(__DIR__, 1) . '/blocks/slider-block/block.json' );

    }
}
