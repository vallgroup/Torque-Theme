<?php

class Dynamic_Email_Body_Class extends Dynamic_Email_Table_Class {

  public static $instance = null;
  private $template;
  private $post_id;
  private $data = array(
    'full_listing_address'  => null,
    'featured_image'        => null,
    'content'               => null,
    'highlights'            => null,
    'gallery'               => null,
    'cta'                   => null,
  );
  private $shared_attributes = array(
    'align'                 => 'center',
    'border'                => '0',
    'cellpadding'           => '0',
    'cellspacing'           => '0',
    'height'                => 'auto',
    'width'                 => "100%",
  );
  private $shared_styles = array();

  public function __construct( $template, $post_id ) {
    $this->template = $template;
    $this->post_id = $post_id;
  }
  
	public static function get_inst( $template, $post_id ) {
		!self::$instance AND self::$instance = new self( $template, $post_id );
		return self::$instance;
	}

  private function get_data() {

    if ( null !== $this->post_id ) :


      /**
       * Project details
       */

      $listing                  = get_field( 'listing', $this->post_id );
    
      // featured image
      $project_featured_image   = null !== get_the_post_thumbnail_url( $this->post_id, 'large')
        ? '<img src="' . get_the_post_thumbnail_url( $this->post_id, 'large') . '" style="width: 100%; max-width: 600px;" />'
        : null;
      $pictures                 = get_field( 'pictures', $this->post_id );
      $cta_url                  = get_post_permalink( $this->post_id );
    
    
      /**
       * Property details
       */
    
      global $post;
      $post = $listing;
      setup_postdata( $post );
      
      $full_listing_address     = '';
      $listing_address          = get_field( 'listing_address' );
      $listing_city             = get_field( 'listing_city' );
      if ( $listing_address && $listing_city ) {
        $full_listing_address   = $listing_address . ', ' . $listing_city;
      }
      
      $content                  = get_the_content();
      $highlights               = get_field( 'listing_highlights' );
    
    endif;

    // template 1
    if ( 'style-1' === $this->template ) {

      $cta_bg_color = self::$colors['medium_green'];
      
    // template 2
    } elseif ( 'style-2' === $this->template ) {


      $cta_bg_color = self::$colors['medium_green'];
    
    // template 3 or otherwise...
    } else {

      $cta_bg_color = self::$colors['dark_green'];

    }

    // address
    $this->data['full_listing_address'] = '<p style="font-size: 18px; margin: 0 auto; font-weight: 600;"><span><?php echo ' . $full_listing_address . '; ?></span></p>';

    // cta
    $this->data['cta'] = ' <a href="' . $cta_url . '" style="color: ' . self::$colors['white'] . '; background-color: ' . $cta_bg_color . '; text-decoration: none; padding: 12px 22px;">Learn More</a>';
    
  }

  public function build_body() {
    
    $this->get_data();

    $inner_html = '';

    // address table top
    if ( 'style-1' === $this->template || 'style-2' === $this->template ) {
      $inner_html .= $this->build_address_tbl();
    }

    // featured image table
    $inner_html .= $this->build_feat_image_tbl();
    
    // address table bottom
    if ( 'style-3' === $this->template ) {
      $inner_html .= $this->build_address_tbl();
    }

    // outer table
    $tag_attributes = array( 'id' => 'header-container' );
    $tag_attributes = array_merge( $this->shared_attributes, $tag_attributes );

    $outer_html = self::build_table_element( 'td', array( $inner_html ) );
    $outer_html = self::build_table_element( 'tr', array( $outer_html ) );
    $outer_html = self::build_table_element( 'tbody', array( $outer_html ) );
    $outer_html = self::build_table_element( 'table', array( $outer_html ), $tag_attributes );

    echo $outer_html; 

  }

  private function build_address_tbl() {

    // table tag styles
    $table_tag_styles = array();
    if ( 'style-1' === $this->template || 'style-2' === $this->template ) {
      $table_tag_styles = array_merge( $this->shared_styles, array( 
        'padding' => '9px 0 0 0',
      ) );
    }
    if ( 'style-3' === $this->template ) {
      $table_tag_styles = array_merge( $this->shared_styles, array( 
        'padding' => '0 0 9px 0',
      ) );
    }

    // table tag attributes
    $table_tag_attributes = array_merge( $this->shared_attributes, array( 
      'ID' => 'body-address-container',
    ) );

    // table html
    $html = self::build_table_element( 'td', $this->data['full_listing_address'], null, $tag_styles );
    $html = self::build_table_element( 'tr', array( $html ) );
    $html = self::build_table_element( 'tbody', array( $html ) );
    $html = self::build_table_element( 'table', array( $html ), $table_tag_attributes );

    return $html;

  }

  private function build_feat_image_tbl() {
    return '<img src="testing..."/>';
  }

}

?>