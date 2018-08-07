<?php

class Torque_Customizer {

  public static $logo_setting_slug = 'torque_logo';

  public function __construct() {
    add_action( 'customize_register', array( $this, 'torque_customize_register_handler' ) );
  }

  public function torque_customize_register_handler( $wp_customize ) {
    $wp_customize->add_setting( self::$logo_setting_slug ); // Add setting for logo uploader

    // Add control for logo uploader (actual uploader)
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, self::$logo_setting_slug, array(
        'label'    => 'Upload Logo',
        'section'  => 'title_tagline',
        'settings' => self::$logo_setting_slug,
    ) ) );
  }
}

?>
