<?php

abstract class Torque_Customizer_Tab {

  /**
   * Hold the wp-customize object we use to add settings and controls
   */
  protected $wp_customize;

  /**
   * Get an array of settings slugs for this tab.
   *
   * This is an opportunity for the child class to pass the settings through a filter,
   * so a child theme can add/remove them.
   *
   * To make sure the setting slugs are only defined in one place
   * the array should be a key value pair where the value is the slug.
   */
  abstract public static function get_settings();

  /**
   * Add the controls to wp_customize.
   *
   * This is an opportunity for the child class to pass wp_customize to an action hook,
   * allowing a child theme to further modify controls.
   */
  abstract protected function add_controls();

  /**
   * Register the action
   */
  public function __construct() {
    add_action( 'customize_register', array( $this, 'torque_customize_register_handler' ) );
  }

  public function torque_customize_register_handler( $wp_customize ) {
    $this->wp_customize = $wp_customize;

    $this->add_settings();
    $this->add_controls();
  }

  private function add_settings() {
    $settings = static::get_settings();

    foreach (array_values($settings) as $setting) {
      $this->wp_customize->add_setting( $setting );
    }
  }
}

?>
