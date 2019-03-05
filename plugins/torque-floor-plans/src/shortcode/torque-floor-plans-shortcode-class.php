<?php

class Torque_Floor_Plans_Shortcode {

  public static $SHORTCODE_SLUG = 'torque_floor_plans';

  private $atts = array();

	private $content = '';

  /**
   * Add the shortcode and link it to our callback
   */
  public function __construct() {
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
    return shortcode_atts(array(
      'example' => true,
      'another'           => '',
    ), $atts);
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
    echo Torque_Floor_Plans_Entrata::get_inst()->PROPERTY_ID;

    return '<div
      class="torque-floor-plans-react-entry"
      data-site="'.get_site_url().'"
      data-1="'.$this->atts['example'].'"
      data-2="'.$this->atts['another'].'" >
      </div>';
  }

}

?>
