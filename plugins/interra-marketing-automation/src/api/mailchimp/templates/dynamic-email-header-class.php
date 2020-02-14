<?php

class Dynamic_Email_Header_Class extends Dynamic_Email_Table_Class {

  public static $instance = null;
  private $template;
  private $header_data = array(
    'logo_url'      => null,
  );
  private $header_styles = array(
    'text-align'    => 'center',
  );
  private $header_attributes = array(
    'id'            => '',
    'align'         => 'center',
    'border'        => '0',
    'cellpadding'   => '10px',
    'cellspacing'   => '0',
    'height'        => '100%',
    'width'         => "100%",
  );

  public function __construct( $template ) {
    $this->template = $template;
  }
  
	public static function get_inst( $template ) {
		!self::$instance AND self::$instance = new self( $template );
		return self::$instance;
	}

  private function get_data() {

    // logo
    require_once( get_template_directory() . '/includes/customizer/customizer-tabs/tabs/torque-customizer-tab-site-identity-class.php' );
    $tab_settings = Torque_Customizer_Tab_Site_Identity::get_settings();

    if ( 'style-1' === $this->template ) {

      $logo_url = get_theme_mod( $tab_settings['logo_white_setting'] )
        ? get_theme_mod( $tab_settings['logo_white_setting'] )
        : null;
      
      $td_styles = array(
        'height'           => '70px',
        'padding'          => '10px',
        'background-color' => isset( Dynamic_Email_Table_Class::$colors['medium_gray'] ) ? Dynamic_Email_Table_Class::$colors['medium_gray'] : 'initial',
      );
      
    } else {
      $logo_url = get_theme_mod( $tab_settings['logo_white_setting'] )
        ? get_theme_mod( $tab_settings['logo_white_setting'] )
        : null;
      
      $td_styles = array(
        'height'           => '130px',
        'padding'          => '30px 10px',
        'background-color' => isset( Dynamic_Email_Table_Class::$colors['white'] ) ? Dynamic_Email_Table_Class::$colors['white'] : 'initial',
      );
    }

    $this->header_data['logo_url'] = '<img src="' . $logo_url . '" height="70px" width="auto" />';
    $this->header_styles = array_merge( $this->header_styles, $td_styles );
    
  }

  public function build_header() {
    
    $this->get_data();

    // inner table
    $this->header_attributes['id'] = 'header-logo-container';
    $html = Dynamic_Email_Table_Class::build_table_element( 'td', $this->header_data, $this->header_attributes, $this->header_styles );
    $html = Dynamic_Email_Table_Class::build_table_element( 'tr', array( $html ) );
    $html = Dynamic_Email_Table_Class::build_table_element( 'tbody', array( $html ) );
    $html = Dynamic_Email_Table_Class::build_table_element( 'table', array( $html ), $this->header_attributes );

    // outer table
    $this->header_attributes['id'] = 'header-container';
    $this->header_attributes['cellpadding'] = '0';
    $html = Dynamic_Email_Table_Class::build_table_element( 'td', array( $html ) );
    $html = Dynamic_Email_Table_Class::build_table_element( 'tr', array( $html ) );
    $html = Dynamic_Email_Table_Class::build_table_element( 'tbody', array( $html ) );
    $html = Dynamic_Email_Table_Class::build_table_element( 'table', array( $html ), $this->header_attributes );

    echo $html;

  }

}

?>