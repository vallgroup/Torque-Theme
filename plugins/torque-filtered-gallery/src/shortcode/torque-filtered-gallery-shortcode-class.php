<?php

require( Torque_Filtered_Gallery_PATH . 'shortcode/torque-filtered-gallery-tinymce-class.php' );

class Torque_Filtered_Gallery_Shortcode {

  public static $SHORTCODE_SLUG = 'torque_filtered_gallery';

  public static $GALLERY_TEMPLATE_FILTER_HANDLE = 'torque_filtered_gallery_template';

  protected $expected_args = array();

  private $atts = array();

	private $content = '';

  /**
   * Add the shortcode and link it to our callback
   */
  public function __construct() {

    // 'gallery_id' - required CPT ID of gallery
    // 'posts_per_page' - max. number of posts to return
    // 'use_lightbox' - utilise a lightbox feature, to open images in fullscreen when clicked
    // 'hide_filters' - hide all filters
    // 'filters_types' - comma separated array of filter types which will have an AND relationship
    //   supported options:
    //     tabs_acf - creates tab filters for a given acf select field (pass the acf field id)
    //
    // 'filters_args' - comma separated array of filter arguments for the types
    $this->expected_args = array(
      'gallery_id'          => '', // required
      'posts_per_page'      => '-1', // optional
      'use_lightbox'        => false, // optional
      'hide_filters'        => false, // optional
      // default args for second method
      'filters_types' => 'tabs_acf',
      'filters_args'  => Torque_Filtered_Gallery_CPT::$FILTERED_GALLERY_CAT_KEY
    );

		add_shortcode( self::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );

    add_action( 'load-post.php'    ,  array(
      Torque_Filtered_Gallery_TinyMCE::get_inst(),
      'init' ),
    20 );
    add_action( 'load-post-new.php',  array(
      Torque_Filtered_Gallery_TinyMCE::get_inst(),
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
          'loop-template' => 'template-'.apply_filters( self::$GALLERY_TEMPLATE_FILTER_HANDLE, "0" ),
          'iframe_button_title' => class_exists('ACF')
            ? get_field( 'iframe_button_title', 'options' )
            : null,
          'iframe_title'        => class_exists('ACF')
            ? get_field( 'iframe_title', 'options' )
            : null,
          'iframe_url'          => class_exists('ACF')
            ? get_field( 'iframe_url', 'options' )
            : null,
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
      class="torque-filtered-gallery-react-entry"
      data-site="'.get_site_url().'"
      '.$exp_args.'>
      </span>';
  }
}

?>
