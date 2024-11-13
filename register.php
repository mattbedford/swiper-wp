<?php


namespace SwiperWP; 


class Register {

  public function __construct() {

    add_action('init', [self::class, 'register_slider_block']);
    add_action('wp_enqueue_scripts', [self::class, 'CheckForSwiper']);
	  add_action('admin_enqueue_scripts', [self::class, 'CheckForSwiper']); // Load front-end styles & scripts even in editor view
	  add_action('admin_enqueue_scripts', [self::class, 'EditorScriptLoad']); // But load other stuff in editor view too
      
  }
  
  
  public static function EditorScriptLoad(): void
  {
	  wp_register_style('swiper-editor-styles', plugin_dir_url(__FILE__) . 'block/editor-style.css');
  }
	
  public static function CheckForSwiper (): void
  {
  	
    if ( has_block("acf/slider-block") || (is_single()) ) {
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
		
		
      	register_block_type( dirname(__FILE__) . '/block' );

    }
}