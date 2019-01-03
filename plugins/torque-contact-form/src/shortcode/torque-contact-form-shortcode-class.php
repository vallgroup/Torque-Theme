<?php

require( Torque_Contact_Form_PATH . 'shortcode/torque-contact-form-tinymce-class.php' );
require( Torque_Contact_Form_PATH . 'form/form-contact.php' );

class Torque_Contact_Form_Shortcode {

  public static $SHORTCODE_SLUG = 'torque_contact_form';

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
    // recipient email defaults to site admin email
    $this->expected_args = array(
      'recipient_email' => get_bloginfo('admin_email'),
    );

		add_shortcode( self::$SHORTCODE_SLUG , array( $this, 'shortcode_handler') );

    add_action( 'load-post.php'    ,  array(
      Torque_Contact_Form_TinyMCE::get_inst(),
      'init' ),
    20 );
    add_action( 'load-post-new.php',  array(
      Torque_Contact_Form_TinyMCE::get_inst(),
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
    return shortcode_atts( array_merge( $this->expected_args,
      // these are your arguments that do not show up in the front end.
      array(
        '' => ''
      ) ), $atts, self::$SHORTCODE_SLUG );
  }


  /**
   * Using the atts and content saved to the instance,
   * we should return some markup here that the shortcoded will be returned as.
   *
   * @return string
   */
  private function get_markup() {
    $form = new Torque_Contact_Form_Form( $this->atts['recipient_email'] );
    return $form->get_form_markup();
  }
}

?>
