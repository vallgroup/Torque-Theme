<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');
require_once( Interra_Marketing_Automation_PATH . 'api/mailchimp/ima-mailchimp-email-templates.php');

class Interra_Marketing_Automation_Mailchimp_Controller {

	protected $request = null;

	public static function get_email_tmpl_args() {
		return array(
			'postID' => array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
      'header' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
      'body' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
      'footer' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
    );
	}

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_email_tmpl() {
		try {

			$params = $this->request->get_params();

			$this->postID = $params['postID'];

			$email_params = [];


			if ( isset( $params['header'] )
				&& ! empty( $params['header'] ) ) {
				$email_params['header'] = $params['header'];
			}
			if ( isset( $params['body'] )
				&& ! empty( $params['body'] ) ) {
				$email_params['body'] = $params['body'];
			}
			if ( isset( $params['footer'] )
				&& ! empty( $params['footer'] ) ) {
				$email_params['footer'] = $params['footer'];
			}

			$email_class = new IMA_Mailchimp_Email_Template( $this->postID, $email_params );

			$email_tmpl = $email_class->get_template();
      return Torque_API_Responses::Success_Response( array(
        'tmpl'	=> $email_tmpl
      ) );

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	public function get_header_tmpl( $style ) {
		$tmpl = new IMA_Mailchimp_Email_Template( 'header', $style, $this->postID );
		return $tmpl->get_template();
	}

	public function get_body_tmpl( $style ) {
		$tmpl = new IMA_Mailchimp_Email_Template( 'body', $style, $this->postID );
		return $tmpl->get_template();
	}

	public function get_footer_tmpl( $style ) {
		$tmpl = new IMA_Mailchimp_Email_Template( 'footer', $style, $this->postID );
		return $tmpl->get_template();
	}
}
