<?php

class Torque_Recaptcha_Shortcode {

  public static $SHORTCODE_SLUG = 'torque_recaptcha';

  protected $expected_args = array();

  private $atts = array();

	private $content = '';

  /**
   * Add the shortcode and link it to our callback
   */
  public function __construct() {
    // use this array to attributes and display them in the front end
    // for private attributes go to setup_atts()
    $this->expected_args = array(
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
    return shortcode_atts( array_merge( $this->expected_args,
      // these are your arguments that do not show up in the front end.
      array(
      ) ), $atts, self::$SHORTCODE_SLUG );
  }


  private function get_markup() {
    $markup = '';
    $recaptcha_version = get_field( 'tq_recaptcha_version', 'option' );
    $form_selector = get_field( 'tq_recaptcha_form_selector', 'option' );
    $api_key = get_field( 'tq_recaptcha_api_key', 'option' );

    if (
      'v2_invisible' === $recaptcha_version
      || 'v3' === $recaptcha_version
    ) {
      // update the form's button, based on the user-provided form CSS selector
      $markup .= '<script>
        document.addEventListener("DOMContentLoaded", function(){
          const theForm = document.querySelector("'.$form_selector.'");
          if ( null !== theForm ) {
            const theButton = theForm.querySelector("[type=\'submit\']");
            theButton.classList.add("g-recaptcha");
            theButton.setAttribute("data-sitekey", "'.$api_key.'");
            theButton.setAttribute("data-callback", "onRecaptchaSubmit");
            theButton.setAttribute("data-action", "submit");
          } else {
            console.warn("Google reCAPTCHA: cannot find a form using selector \''.$form_selector.'\'");
          }
        });
      </script>';
    } elseif ( 'v2_checkbox' === $recaptcha_version ) {
      $markup .= '<div class="g-recaptcha" data-sitekey="'.$api_key.'"></div>';
    } else {
      $markup = 'Please configure the Google reCAPTCHA options and reload the page.';
    }

    return $markup;
  }
}

?>
