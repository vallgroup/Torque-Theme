<?php

class Torque_Map_Shortcode {

  public static $SHORTCODE_SLUG = 'torque_map';

  protected $expected_args = array();

  private $atts = array();

	private $content = '';

  /**
   * Add the shortcode and link it to our callback
   */
  public function __construct() {

    $this->expected_args = array(
      'center' => '',
      'center_marker' => '', // mixed
      'api_key' => '',
      'map_id' => '',
    );

		add_shortcode( self::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );
	}

  /**
   * The callback for the shortcode, should output some markup to be displayed.
   *
   * @param  array $atts     Attributes found when parsing shortcode
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
    return shortcode_atts( $this->expected_args, $atts );
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
    foreach ( $this->atts as $key => $arg ) {
      if ( empty( $arg ) )
        continue;
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
