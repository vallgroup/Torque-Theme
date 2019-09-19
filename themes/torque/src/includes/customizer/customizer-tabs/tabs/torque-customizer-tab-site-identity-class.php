<?php

require_once( get_template_directory() . '/includes/customizer/customizer-tabs/torque-customizer-tab-abstract-class.php');

class Torque_Customizer_Tab_Site_Identity extends Torque_Customizer_Tab {

  public static $section_name = 'title_tagline';

  public static $settings_filter_handle = 'torque_customizer_site_identity_tab_settings';
  public static $controls_hook_handle = 'torque_customizer_site_identity_tab_controls';

  public static function get_settings() {
    $settings = array(
      'logo_setting'        => 'torque_logo',
      'logo_white_setting'  => 'torque_logo_white'
    );

    return apply_filters( self::$settings_filter_handle, $settings );
  }

  public function __construct() {
    parent::__construct();
  }

  protected function add_controls() {
    $settings = self::get_settings();

    // logo uploaders
    $this->wp_customize->add_control( new WP_Customize_Image_Control( $this->wp_customize, $settings['logo_setting'], array(
        'label'    => 'Upload Dark Logo',
        'section'  => self::$section_name,
        'settings' => $settings['logo_setting'],
    ) ) );
    $this->wp_customize->add_control( new WP_Customize_Image_Control( $this->wp_customize, $settings['logo_white_setting'], array(
        'label'    => 'Upload White Logo (for dark backgrounds)',
        'section'  => self::$section_name,
        'settings' => $settings['logo_white_setting'],
    ) ) );

    // allow child theme to add custom controls
    do_action( self::$controls_hook_handle, $this->wp_customize, self::$section_name );
  }
}

?>
