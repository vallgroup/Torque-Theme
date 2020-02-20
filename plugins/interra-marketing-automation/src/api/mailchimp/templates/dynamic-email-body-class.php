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

    /**
     * General Styling
     */

    // template 1
    if ( 'style-1' === $this->template ) {
      $cta_bg_color = self::$colors['medium_green'];

    // template 2
    } elseif ( 'style-2' === $this->template ) {
      $cta_bg_color = self::$colors['dark_green'];
    
    // template 3 or otherwise...
    } else {
      $cta_bg_color = self::$colors['medium_green'];
    }

    if ( null !== $this->post_id ) :

      /**
       * Project details
       */

      $listing                  = get_field( 'listing', $this->post_id );
      $project_featured_image   = get_the_post_thumbnail_url( $this->post_id, 'large');
      $pictures                 = get_field( 'pictures', $this->post_id );
      $gallery                  = array();
      $cta_url                  = get_post_permalink( $this->post_id );

      for ($i=0; $i < 2 ; $i++) {
        if ( isset( $pictures[$i] ) ) {
          $gallery[] = '<img src="' . $pictures[$i]['sizes']['medium'] . '" width="100%" height="auto" />';
        }
      }
    
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
      $highlights_heading       = 'style-1' === $this->template || 'style-3' === $this->template
        ? '<h3 style="font-size: 22px; color: ' . self::$colors['medium_green'] . '; text-transform: uppercase; margin: 0 auto;">Property <span style="color: ' . self::$colors['medium_gray'] . ';">Highlights</span></h3>'
        : '<h3 style="font-size: 22px; color: ' . self::$colors['dark_green'] . '; margin: 0 auto;">Property Highlights</h3>';
      
      // reset post data
      wp_reset_postdata();

      /**
       * Save to class instance
       */

      // address
      $this->data['full_listing_address'] = null !== $full_listing_address
        ? '<p style="font-size: 18px; margin: 0 auto; font-weight: 500;"><span>' . $full_listing_address . '</span></p>'
        : '';
  
      // featured image
      $this->data['featured_image'] = null !== $project_featured_image
        ? '<img src="' . $project_featured_image . '" style="width: 100%; max-width: 600px;" />'
        : '';
      
      // content
      $this->data['content'] = null !== $content
        ? $content
        : '';

      // highlights
      $this->data['highlights'] = null !== $highlights
        ? $highlights_heading . $highlights
        : '';

      // gallery
      $this->data['gallery'] = null !== $gallery
        ? $gallery
        : '';
  
      // cta
      $this->data['cta'] = ' <a href="' . $cta_url . '" style="color: ' . self::$colors['white'] . '; background-color: ' . $cta_bg_color . '; text-decoration: none; padding: 12px 22px;">Learn More</a>';
    
    endif;
    
  }

  /**
   * This function builds the elements for the body, 
   * from the innermost nested to the outer container,
   * therefore it reads in reverse order...
   */
  public function build_body() {
    
    $this->get_data();

    $inner_html = '';

    // address table above featured image
    if ( 'style-1' === $this->template || 'style-3' === $this->template ) {
      $inner_html .= $this->build_address_tbl();
    }

    // featured image table
    $inner_html .= $this->build_feat_image_tbl();
    
    // content & address table below featured image
    if ( 'style-2' === $this->template ) {
      $inner_html .= $this->build_address_tbl();
      $inner_html .= $this->build_content_tbl();
    }

    // featured highlights table
    $inner_html .= $this->build_highlights_tbl();
    
    // gallery table
    if ( 'style-1' === $this->template || 'style-2' === $this->template ) {
      $inner_html .= $this->build_gallery_tbl();
    }    

    // CTA table
    $inner_html .= $this->build_cta_tbl();


    // additional td styles
    $additional_td_styles = array_merge( $this->shared_styles, array(
      'padding' => '0 18px'
    ) );

    // additional outer table attributes
    $additional_table_atts = array_merge( $this->shared_attributes, array(
      'id'      => 'body-container',
      'class'   => $this->template
    ) );

    $outer_html = self::build_table_element( 'td', array( $inner_html ), null, $additional_td_styles );
    $outer_html = self::build_table_element( 'tr', array( $outer_html ) );
    $outer_html = self::build_table_element( 'tbody', array( $outer_html ) );
    $outer_html = self::build_table_element( 'table', array( $outer_html ), $additional_table_atts );

    echo trim( $outer_html );

  }


  /**
   * Address Table
   */
  private function build_address_tbl() {

    // additional td styles
    $additional_td_styles = array_merge( $this->shared_styles, array( 
      'padding'         => '9px 18px',
      'text-align'      => 'center',
      'text-transform'  => 'uppercase',
      'color'           => self::$colors['white']
    ) );

    // conditional styles
    if ( 'style-1' === $this->template || 'style-3' === $this->template ) {
      $additional_td_styles = array_merge( $additional_td_styles, array( 
        'background-color' => self::$colors['medium_green']
      ) );
    }
    if ( 'style-2' === $this->template ) {
      $additional_td_styles = array_merge( $additional_td_styles, array( 
        'background-color' => self::$colors['dark_green']
      ) );
    }

    // additional table attributes
    $additional_table_atts = array_merge( $this->shared_attributes, array(
      'id' => 'body-address-container'
    ) );

    // table html
    $html = self::build_table_element( 'td', array( $this->data['full_listing_address'] ), null, $additional_td_styles );
    $html = self::build_table_element( 'tr', array( $html ) );
    $html = self::build_table_element( 'tbody', array( $html ) );
    $html = self::build_table_element( 'table', array( $html ), $additional_table_atts, $this->shared_styles );

    return $html;

  }


  /**
   * Featured Image Table
   */
  private function build_feat_image_tbl() {

    // additional table styles
    $additional_table_styles = array_merge( $this->shared_styles, array( 
      'padding'   => '9px 0',
    ) );

    // additional table attributes
    $additional_table_atts = array_merge( $this->shared_attributes, array(
      'id'        => 'body-featured-image'
    ) );
    
    // table html
    $html = self::build_table_element( 'td', array( $this->data['featured_image'] ), null, null );
    $html = self::build_table_element( 'tr', array( $html ) );
    $html = self::build_table_element( 'tbody', array( $html ) );
    $html = self::build_table_element( 'table', array( $html ), $additional_table_atts, $additional_table_styles );

    return $html;
  }


  /**
   * Contents Table
   */
  private function build_content_tbl() {

    // additional table styles
    $additional_td_styles = array_merge( $this->shared_styles, array(
      'text-align'  => 'left',
      'padding'     => '35px 0 25px',
      'line-height' => '1.1',
    ) );

    // additional table attributes
    $additional_table_atts = array_merge( $this->shared_attributes, array( 
      'id'          => 'body-content'
    ) );
    
    // table html
    $html = self::build_table_element( 'td', array( $this->data['content'] ), null, $additional_td_styles );
    $html = self::build_table_element( 'tr', array( $html ) );
    $html = self::build_table_element( 'tbody', array( $html ) );
    $html = self::build_table_element( 'table', array( $html ), $additional_table_atts, $this->shared_styles );

    return $html;
  }


  /**
   * Highlights Table
   */
  private function build_highlights_tbl() {

    // additional table styles
    $additional_td_styles = array_merge( $this->shared_styles, array( 
      'text-align'  => 'left',
      'padding'     => '9px 0',
      'line-height' => '1.1',
    ) );

    // additional table attributes
    $additional_table_atts = array_merge( $this->shared_attributes, array( 
      'id'          => 'body-content'
    ) );
    
    // table html
    $html = self::build_table_element( 'td', array( $this->data['highlights'] ), null, $additional_td_styles );
    $html = self::build_table_element( 'tr', array( $html ) );
    $html = self::build_table_element( 'tbody', array( $html ) );
    $html = self::build_table_element( 'table', array( $html ), $additional_table_atts, $this->shared_styles );

    return $html;
  }


  /**
   * Gallery Table
   */
  private function build_gallery_tbl() {

    /**
     * Two Columns
     */
    $inner_cols = array();

    // additional col table styles
    $additional_col_table_styles = array_merge( $this->shared_styles, array( 
      'width'       => '100%',
      'max-width'   => '281px',
    ) );
    
    // get first two images
    $i = 0;
    foreach ( $this->data['gallery'] as $image ) {

        // additional col td styles
        $additional_col_td_styles = 0 === $i
          ? array_merge( $this->shared_styles, array( 
            'padding' => '0 9px 9px 0',
          ) )
          : array_merge( $this->shared_styles, array( 
            'padding' => '0 0 9px 9px',
          ) );

        // additional col table attributes
        $additional_col_table_atts = array_merge( $this->shared_attributes, array( 
          'id' => 'gallery-col' . ( (int) $i + 1 )
        ) );
        $additional_col_table_atts['align'] = 'left';
        
        // col table html
        $inner_cols[$i] = self::build_table_element( 'td', array( $image ), null, $additional_col_td_styles );
        $inner_cols[$i] = self::build_table_element( 'tr', array( $inner_cols[$i] ) );
        $inner_cols[$i] = self::build_table_element( 'tbody', array( $inner_cols[$i] ) );
        $inner_cols[$i] = self::build_table_element( 'table', array( $inner_cols[$i] ), $additional_col_table_atts, $additional_col_table_styles );

        // increment counter
        $i++;
    }

    /**
     * Outer Table
     */
    // additional outer table styles
    $additional_td_styles = array_merge( $this->shared_styles, array( 
      'text-align'  => 'left',
      'padding'     => '20px 0 35px',
      'line-height' => '1.1',
    ) );

    // additional outer table attributes
    $additional_table_atts = array_merge( $this->shared_attributes, array( 
      'id'          => 'body-gallery'
    ) );
    
    // outer table html
    $html = self::build_table_element( 'td', $inner_cols, null, $additional_td_styles );
    $html = self::build_table_element( 'tr', array( $html ) );
    $html = self::build_table_element( 'tbody', array( $html ) );
    $html = self::build_table_element( 'table', array( $html ), $additional_table_atts, $this->shared_styles );

    return $html;
  }


  /**
   * CTA Table
   */
  private function build_cta_tbl() {

    // additional table styles
    $additional_td_styles = array_merge( $this->shared_styles, array( 
      'text-align'  => 'center',
      'padding'     => '18px 9px',
    ) );

    // additional table attributes
    $additional_table_atts = array_merge( $this->shared_attributes, array( 
      'id'          => 'body-cta'
    ) );
    
    // table html
    $html = self::build_table_element( 'td', array( $this->data['cta'] ), null, $additional_td_styles );
    $html = self::build_table_element( 'tr', array( $html ) );
    $html = self::build_table_element( 'tbody', array( $html ) );
    $html = self::build_table_element( 'table', array( $html ), $additional_table_atts, $this->shared_styles );

    return $html;
  }

}

?>