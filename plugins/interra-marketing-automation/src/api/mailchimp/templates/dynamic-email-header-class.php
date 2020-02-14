<?php

class Dynamic_Email_Header_Class extends Dynamic_Email_Table_Class {

  public static $instance = null;
  private $template;
  private $header_data = array(
    'logo_url'  => null,
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
    } else {
      $logo_url = get_theme_mod( $tab_settings['logo_white_setting'] )
        ? get_theme_mod( $tab_settings['logo_white_setting'] )
        : null;
    }

    $this->header_data['logo_url'] = '<img src="' . $logo_url . '" height="85px" width="auto" />';
    
  }

  public function build_header() {
    $this->get_data();
    // echo hard-code remainder of header here?
    echo Dynamic_Email_Table_Class::build_table_element( 'td', $this->header_data );
    // echo hard-code remainder of header here?
  }

}

?>