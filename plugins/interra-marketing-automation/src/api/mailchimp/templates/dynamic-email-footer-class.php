<?php

class Dynamic_Email_Footer_Class extends Dynamic_Email_Table_Class {

  public static $instance = null;
  private $template;
  private $post_id;
  private $data = array(
    // general
    'site_url'        => null,
    'logo'            => null,
    'address'         => null,
    'email'           => null,
    'phone'           => null,
    'social_channels' => null,
    // brokers
    'brokers'         => array(),
  );
  private $shared_attributes = array(
    'id'              => '',
    'align'           => 'center',
    'border'          => '0',
    'cellpadding'     => '15px',
    'cellspacing'     => '0',
    'height'          => '100%',
    'width'           => "100%",
  );
  private $shared_styles = array(
    'margin-top'      => '55px',
  );

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
      $accent_color = self::$colors['white'];
    // template 3 or otherwise...
    } else {
      $accent_color = self::$colors['medium_green'];
    }


    /**
     * General Content
     */

    // logo_url
    require_once( get_template_directory() . '/includes/customizer/customizer-tabs/tabs/torque-customizer-tab-site-identity-class.php' );
    $tab_settings = Torque_Customizer_Tab_Site_Identity::get_settings();

    if ( 'style-1' === $this->template ) {
      $logo_url = get_theme_mod( $tab_settings['logo_white_setting'] )
        ? get_theme_mod( $tab_settings['logo_white_setting'] )
        : null;
    } else {
      $logo_url = get_theme_mod( $tab_settings['logo_setting'] )
        ? get_theme_mod( $tab_settings['logo_setting'] )
        : null;
    }

    $address                    = get_field('address', 'options');
    $phone                      = get_field('phone', 'options');
    // NB: added email to options page....
    $email                      = get_field('email', 'options');
    $site_url                   = get_site_url();

    // social channels
    if ( have_rows('social_media', 'options') ) :
      $social_channels = '<ul style="list-style: none; text-align: center; padding: 0;">';
      while ( have_rows('social_media', 'option') ) : the_row();
        $socialchannel = get_sub_field( 'social_channel', 'option' );
        $socialurl = get_sub_field( 'social_url', 'option' );
        $social_channels .= '<li style="width: 20%; display: inline-block;"><a style="text-decoration: none; color: inherit;" rel="nofollow noopener noreferrer" href="' . $socialurl . '" target="_blank">' . ucfirst( $socialchannel ) . '</a></li>';
      endwhile;
      $social_channels .= '</ul>';
    endif;


    /**
     * Brokers Content
     */
    $listing = get_field( 'listing', $this->post_id );
    global $post;
    $post = $listing;
    setup_postdata( $post );
    $users = get_field( 'listing_brokers' );
    if ( $users ) :
      $brokers = '<p><span style="font-style: italic;">For More Information Contact:</span></p>';
    	foreach ( $users as $user ) : // variable must NOT be called $post (IMPORTANT)
        if (!$user) continue; // early skip
        $name = $user->data->display_name;
        $phone = get_field( 'telephone', 'user_'.$user->ID );
        $email = $user->user_email;

        $brokers .= '<p><span style="font-weight: bold;">' . $name . '</span><br><a href="mailto: ' . $email . '" style="text-decoration: none; color: inherit;">' . $email . '</a><br>' . $phone;
      endforeach;
    endif;

    // reset post data
    wp_reset_postdata();


    /**
     * Save to Class
     */

    // logo
    $this->data['logo'] = $logo_url
      ? '<img src="' . $logo_url . '" height="86px" width="auto" />'
      : '';
    
    // address
    $this->data['address'] = $address
      ? $address
      : '';
    
    // phone
    $this->data['phone'] = $phone
      ? $phone
      : '';
    
    // email
    $this->data['email'] = $email
      ? '<a href="mailto:' . $email . '" target="_blank" style="color: ' . $accent_color . '">' . $email . '</a>'
      : '';
    
    // site url
    $this->data['site_url'] = $site_url
      ? '<a href="' . $site_url . '" target="_blank" style="color: ' . $accent_color . '">' . $site_url . '</a>'
      : '';
    
    // social channels
    $this->data['social_channels'] = $social_channels
      ? $social_channels
      : '';
    
    // brokers
    $this->data['brokers'] = $brokers
      ? $brokers
      : '';

  }

  public function build_footer() {
    
    $this->get_data();

    if ( 'style-1' === $this->template ) {
      $this->build_footer_style_1();
    } else {
      $this->build_footer_style_2();
    }

  }

  private function build_footer_style_1() {

    // Applicable to both col 1 & col 2
    $additional_col_table_styles = array_merge( $this->shared_styles, array( 
      'width'       => '100%',
      'max-width'   => '281px',
      'margin-top'  => '0',
    ) );
    $additional_col_table_atts['align'] = 'left';
    $additional_col_table_atts['cellpadding'] = '10px';

    /**
     * Column 1
     */

    // compose into tr/td string
    $inner_html_col_1 = '';
    $included_data = array(
      'logo',
      'address',
    );
    foreach ( $included_data as $key ) {
      $inner_data = self::build_table_element( 'td', array( $this->data[ $key ] ) );
      $inner_html_col_1 .= self::build_table_element( 'tr', array( $inner_data ) );
    }
    $inner_html_col_1 = self::build_table_element( 'tbody', array( $inner_html_col_1 ) );
    $inner_html_col_1 = self::build_table_element( 'table', array( $inner_html_col_1 ), $additional_col_table_atts, $additional_col_table_styles );

    /**
     * Column 2
     */

    // compose into tr/td string
    $inner_html_col_2 = self::build_table_element( 'td', array( $this->data['brokers'] ) );
    $inner_html_col_2 = self::build_table_element( 'tr', array( $inner_html_col_2 ) );
    $inner_html_col_2 = self::build_table_element( 'tbody', array( $inner_html_col_2 ) );
    $inner_html_col_2 = self::build_table_element( 'table', array( $inner_html_col_2 ), $additional_col_table_atts, $additional_col_table_styles );

    /**
     * Outer Table
     */

    // additional outer table attributes
    $additional_outer_table_styles = array_merge( $this->shared_styles, array(
      'background-color'  => self::$colors['medium_gray'],
      'text-align'        => 'left',
      'color'             => self::$colors['white'],
    ) );

    // additional outer table attributes
    $additional_outer_table_atts = array_merge( $this->shared_attributes, array(
      'id'    => 'footer-container',
      'class' => $this->template,
    ) );

    // html
    $outer_html = self::build_table_element( 'td', array( $inner_html_col_1, $inner_html_col_2 ) );
    $outer_html = self::build_table_element( 'tr', array( $outer_html ) );
    $outer_html = self::build_table_element( 'tbody', array( $outer_html ) );
    $outer_html = self::build_table_element( 'table', array( $outer_html ), $additional_outer_table_atts, $additional_outer_table_styles );

    echo $outer_html;
  }

  private function build_footer_style_2() {

    // additional outer td attributes
    $additional_outer_td_styles = array_merge( $this->shared_styles, array(
      'border-top'        => '1px solid #eee',
    ) );

    // additional outer table attributes
    $additional_outer_table_styles = array_merge( $this->shared_styles, array(
      'background-color'  => self::$colors['white'],
      'text-align'        => 'center',
      'color'             => 'initial',
    ) );

    // additional outer table attributes
    $additional_outer_table_atts = array_merge( $this->shared_attributes, array(
      'id'    => 'footer-container',
      'class' => $this->template,
    ) );

    // compose into tr/td string
    $inner_html = '';
    $included_data = array(
      'logo',
      'email',
      'phone',
      'address',
      'site_url',
      'social_channels',
    );
    foreach ( $included_data as $key ) {
      $inner_data = self::build_table_element( 'td', array( $this->data[ $key ] ) );
      $inner_html .= self::build_table_element( 'tr', array( $inner_data ) );
    }
    
    // outer table
    $outer_html = self::build_table_element( 'td', array( $inner_html ), null, $additional_outer_td_styles );
    $outer_html = self::build_table_element( 'tr', array( $outer_html ) );
    $outer_html = self::build_table_element( 'tbody', array( $outer_html ) );
    $outer_html = self::build_table_element( 'table', array( $outer_html ), $additional_outer_table_atts, $additional_outer_table_styles );

    echo $outer_html;
  }

}

?>