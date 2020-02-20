<?php

class Dynamic_Email_Header_Class extends Dynamic_Email_Table_Class {

  public static $instance = null;
  private $template;
  private $data = array(
    'logo_url'      => null,
  );
  private $shared_attributes = array(
    'id'            => '',
    'align'         => 'center',
    'border'        => '0',
    'cellpadding'   => '10px',
    'cellspacing'   => '0',
    'height'        => '100%',
    'width'         => "100%",
  );
  private $shared_styles = array(
    'height'        => '70px',
    'padding'       => '10px',
    'text-align'    => 'center',
  );

  public function __construct( $template ) {
    $this->template = $template;
  }
  
	public static function get_inst( $template ) {
		!self::$instance AND self::$instance = new self( $template );
		return self::$instance;
	}

  private function get_data() {

    // logo_url
    require_once( get_template_directory() . '/includes/customizer/customizer-tabs/tabs/torque-customizer-tab-site-identity-class.php' );
    $tab_settings = Torque_Customizer_Tab_Site_Identity::get_settings();

    if ( 'style-1' === $this->template ) {

      $logo_url = get_theme_mod( $tab_settings['logo_white_setting'] )
        ? get_theme_mod( $tab_settings['logo_white_setting'] )
        : null;
      
      $td_shared_styles = array(
        'background-color' => isset( self::$colors['medium_gray'] ) ? self::$colors['medium_gray'] : 'initial',
      );
      
    } else {
      $logo_url = get_theme_mod( $tab_settings['logo_setting'] )
        ? get_theme_mod( $tab_settings['logo_setting'] )
        : null;
      
      $td_shared_styles = array(
        'background-color' => isset( self::$colors['white'] ) ? self::$colors['white'] : 'initial',
      );
    }

    $this->data['logo_url'] = '<img src="' . $logo_url . '" height="70px" width="auto" />';
    $this->shared_styles = array_merge( $this->shared_styles, $td_shared_styles );
    
  }

  public function build_header() {
    
    $this->get_data();

    // inner table
    $inner_html = self::build_table_element( 'td', $this->data, $this->shared_attributes, $this->shared_styles );
    $this->shared_attributes['cellpadding'] = '0';
    $inner_html = self::build_table_element( 'tr', array( $inner_html ) );
    $inner_html = self::build_table_element( 'tbody', array( $inner_html ) );
    $this->shared_attributes['id'] = 'header-logo-container';
    $inner_html = self::build_table_element( 'table', array( $inner_html ), $this->shared_attributes, $this->shared_styles );

    // additional outer table attributes
    $additional_outer_table_styles = array_merge( $this->shared_styles, array(
      'margin-bottom' => '9px'
    ) );

    // outer table
    $outer_html = self::build_table_element( 'td', array( $inner_html ) );
    $outer_html = self::build_table_element( 'tr', array( $outer_html ) );
    $outer_html = self::build_table_element( 'tbody', array( $outer_html ) );
    $this->shared_attributes['id'] = 'header-container';
    $outer_html = self::build_table_element( 'table', array( $outer_html ), $this->shared_attributes , $additional_outer_table_styles );

    echo $outer_html;


    /* // inner table
    $this->shared_attributes['id'] = 'header-logo-container';

    self::start_table();
    $inner_html = self::build_table_element( 'td', $this->data, $this->shared_attributes, $this->shared_styles );
    echo $inner_html;

    // outer table
    $this->shared_attributes['id'] = 'header-container';
    $this->shared_attributes['cellpadding'] = '0';

    self::start_table();
    $html = self::build_table_element( 'td', array( self::end_table( $this->shared_attributes ) ) );
    echo $html;
    echo self::end_table( $this->shared_attributes ); */

  }

}

?>