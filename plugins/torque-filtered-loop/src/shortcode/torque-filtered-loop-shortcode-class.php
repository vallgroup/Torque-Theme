<?php

require( Torque_Filtered_Loop_PATH . 'shortcode/torque-filtered-loop-tinymce-class.php' );

class Torque_Filtered_Loop_Shortcode {

  public static $SHORTCODE_SLUG = 'torque_filtered_loop';

  public static $LOOP_TEMPLATE_FILTER_HANDLE = 'torque_filtered_loop_loop_template';

  protected $expected_args = array();

  private $atts = array();

	private $content = '';

  /**
   * Add the shortcode and link it to our callback
   */
  public function __construct() {
    // use this array to attributes and display them in the front end
    // for private attributes go to setup_atts()
    //
    // 2 ways to build filters:
    //
    // 1. use a combination of 'tax', 'parent', and 'first_term' to build simple tax filters
    //
    // 'tax' - a wordpress tanonomy slug
    // 'parent' - show child terms of a parent term (pass slug)
    // 'first_term' - show a certain term first (pass ID)
    //
    // 2. more complex filters of different types
    //
    // 'filters_types' - comma separated array of filter types which will have an AND relationship
    //   supported options:
    //     tabs_acf - creates tab filters for a given acf select field (pass the acf field id)
    //     dropdown_tax - creates dropdown filter for a given wp tax (pass the tax slug)
    //     tabs_tax - creates tab filter for a given wp tax (pass the tax slug)
    //     tabs_tax_multi - creates multi-select tab filter for a given wp tax (pass the tax slug)
    //     dropdown_date - creates dropdown filter for filtering by month (no args)
    //     tabs_date - creates tab filter for filtering by month (no args)
    //
    // 'filters_args' - comma separated array of filter arguments for the types
    //
    $this->expected_args = array(
      'post_type'      => 'posts', // always required
      'posts_per_page' => '-1', // optional

      // args for first method
      'tax'           => '',
      'parent'        => '',
      'first_term'    => '',

      // args for second method
      'filters_types' => '',
      'filters_args'  => ''
    );

		add_shortcode( self::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );

    add_action( 'load-post.php'    ,  array(
      Torque_Filtered_Loop_TinyMCE::get_inst(),
      'init' ),
    20 );
    add_action( 'load-post-new.php',  array(
      Torque_Filtered_Loop_TinyMCE::get_inst(),
      'init' ),
    20 );
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

    return shortcode_atts( array_merge(
        $this->expected_args,
        // these are your arguments that do not show up in the front end.
        array(
          'loop-template' => 'template-'.apply_filters( self::$LOOP_TEMPLATE_FILTER_HANDLE, "0" ),
        )
      ), $atts, self::$SHORTCODE_SLUG );
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
      class="torque-filtered-loop-react-entry"
      data-site="'.get_site_url().'"
      '.$exp_args.'>
      </span>';
  }
}

?>
