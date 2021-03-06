<?php

/**
 * TQ
 *
 * Utilities Class v.1.0
 *
 * @package 	WordPress
 * @subpackage 	Torque Theme
 * @author 		Torque
 *
 *
 */

 class TQ {

  	/**
  	 * Print a pre formatted array to the browser - very useful for debugging
  	 *
  	 * @param 	array
  	 * @return 	void
  	 **/
  	public static function print_a( $a ) {
  		print( '<pre>' );
  		print_r( $a, true );
  		print( '</pre>' );
  	}

  	/**
  	 * Simple wrapper for native get_template_part()
  	 * Allows you to pass in an array of parts and output them in your theme
  	 * e.g. <?php get_template_parts(array('part-1', 'part-2')); ?>
  	 *
  	 * @param 	array
  	 * @return 	void
  	 **/
  	public static function get_template_parts( $parts = array() ) {
  		foreach( $parts as $part ) {
  			get_template_part( $part );
  		};
  	}

  	/**
  	 * Pass in a path and get back the page ID
  	 * e.g. TQ::get_page_id_from_path('about/terms-and-conditions');
  	 *
  	 * @param 	string
  	 * @return 	integer
  	 **/
  	public static function get_page_id_from_path( $path ) {
  		$page = get_page_by_path( $path );
  		if( $page ) {
  			return $page->ID;
  		} else {
  			return null;
  		};
  	}

  	/**
  	 * Append page slugs to the body class
  	 * NB: Requires init via add_filter( 'body_class', array( 'TQ', 'add_slug_to_body_class' ) );
  	 *
  	 * @param 	array
  	 * @return 	array
  	 */
  	public static function add_slug_to_body_class( $classes ) {
  		global $post;

  		if( is_home() ) {
  			$key = array_search( 'blog', $classes );
  			if($key > -1) {
  				unset( $classes[$key] );
  			};
  		} elseif( is_page() ) {
  			$classes[] = sanitize_html_class( $post->post_name );
  		} elseif(is_singular()) {
  			$classes[] = sanitize_html_class( $post->post_name );
  		};

  		return $classes;
  	}

  	/**
  	 * Get the category id from a category name
  	 *
  	 * @param 	string
  	 * @return 	string
  	 */
  	public static function get_category_id( $cat_name ){
  		$term = get_term_by( 'name', $cat_name, 'category' );
  		return $term->term_id;
  	}

    public static function array_swap_assoc($key1, $key2, $array) {
      $newArray = array ();
      foreach ($array as $key => $value) {
        if ($key == $key1) {
          $newArray[$key2] = $array[$key2];
        } elseif ($key == $key2) {
          $newArray[$key1] = $array[$key1];
        } else {
          $newArray[$key] = $value;
        }
      }
      return $newArray;
    }
  }
