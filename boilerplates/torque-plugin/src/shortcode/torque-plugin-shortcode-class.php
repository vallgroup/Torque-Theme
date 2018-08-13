<?php

class <torque_plugin_class_name>_Shortcode {

  public static $SHORTCODE_SLUG = '<torque_plugin_shortcode>';

  protected $expected_args = array();

  private $atts = array();

	private $content = '';

  /**
   * Add the shortcode and link it to our callback
   */
  public function __construct() {
    // use this array to attributes and display them in the front end
    // for private attributes go to setup_atts()
    $this->$expected_args = array(
      'example' => true,
    );

		add_shortcode( self::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );
	}

  /**
   * The callback for the shortcode, should output some markup to be displayed.
   *
   * @param  array $atts    Attributes found when parsing shortcode
   * @param  string $content Children found inside enclosing shortcode tags
   * @return string
   */
  public function shortcode_handler( $atts, $content ) {
    $this->atts = $this->setup_atts( $atts );
    $this->content = $content;

    return $this->get_markup();
  }

  /**
   * Combing the atts found when parsing the shortcode with our default atts
   *
   * @param  array $atts    Attributes found when parsing shortcode
   * @return array       Attributes combined with our defaults
   */
  private function setup_atts($atts) {
    return shortcode_atts( array_merge( $this->$expected_args,
      // these are your arguments that do not show up in the front end.
      array(
        '' => ''
      ) ), $atts, self::$SHORTCODE_SLUG );
  }

  /**
   * Using the atts and content saved to the instance,
   * we should return some markup here that the shortcoded will be returned as.
   *
   * Note we pass the site url through to allow our axios url to depend on the WP site.
   *
   * @return string
   */
  private function get_markup() {
    $exp_args = '';
    foreach ( $this->$atts as $key => $arg ) {
      $exp_args .= ' data-'.esc_attr( $key ).'="'.$arg.'"';
    }
    return '<span
      class="torque-map-react-entry"
      data-site="'.get_site_url().'"
      '.$exp_args.'>
      </span>';
  }

}

?>
