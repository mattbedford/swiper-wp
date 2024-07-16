<?php


namespace SwiperWP; 


class Register {

  public function __construct() {

    add_action('init', [self::class, 'register_slider_block']);
    add_action('wp_enqueue_scripts', [self::class, 'CheckForSwiper']);
      
  }
  
  
  public static function CheckForSwiper (): void
  {
  	
    if ( has_block("acf/slider-block") ) {
        wp_register_script(
            'swiper-js',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            [],
            false,
            false
        );
	   wp_register_style('swiper-custom-styles', plugin_dir_url(__FILE__) . 'block/style.css');
       wp_register_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    } 
  }


    public static function register_slider_block() {
		
		//register_block_type( dirname(__FILE__) . '/block/block.json' );
		      register_block_type( dirname(__FILE__) . '/block' );

    }
}