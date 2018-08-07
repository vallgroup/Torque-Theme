<?php

class Torque_Customizer {

  public static $logo_setting_slug = 'torque_logo';
  public static $logo_white_setting_slug = 'torque_logo_white';

  public function __construct() {
    add_action( 'customize_register', array( $this, 'torque_customize_register_handler' ) );
  }

  public function torque_customize_register_handler( $wp_customize ) {
    $this->add_settings( $wp_customize );
    $this->add_controls( $wp_customize );
  }

  private function add_settings( $wp_customize ) {
    // logo uploaders
    $wp_customize->add_setting( self::$logo_setting_slug );
    $wp_customize->add_setting( self::$logo_white_setting_slug );
  }

  private function add_controls( $wp_customize ) {
    // logo uploaders
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, self::$logo_setting_slug, array(
        'label'    => 'Upload Dark Logo',
        'section'  => 'title_tagline',
        'settings' => self::$logo_setting_slug,
    ) ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, self::$logo_white_setting_slug, array(
        'label'    => 'Upload White Logo (for dark backgrounds)',
        'section'  => 'title_tagline',
        'settings' => self::$logo_white_setting_slug,
    ) ) );
  }
}

?>
