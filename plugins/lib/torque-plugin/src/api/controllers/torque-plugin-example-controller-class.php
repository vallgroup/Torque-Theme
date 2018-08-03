<?php

require_once( get_template_directory() . 'api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . 'includes/validation/torque-validation-class.php');

class <torque_plugin_class_name>_Example_Controller {

	public static function get_example_args() {
		return array(
      'id' => array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
    );
	}

	public static function update_example_args() {
		return array(
			'id' => array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
      'name' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
    );
	}

	public static function delete_example_args() {
		return array(
			'id' => array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
    );
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_examples() {
		try {
			$example = get_example( $this->request['id'] );

			if ($example) {
        return Torque_API_Responses::Success_Response( array(
          'example'	=> $example
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'example'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	public function update_example() {
		try {
      $example_id = update_example( $this->request['id'], $this->request['name'] );

			if ($example_id) {
				return Torque_API_Responses::Success_Response( array(
					'id'			=> $example_id
	    	) );
			} else {
				return Torque_API_Responses::Failure_Response( array(
					'id'			=> 0
	    	));
			}

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	public function delete_example() {
		try {
			if (delete_example( $this->request['id'] )) {
				return Torque_API_Responses::Success_Response();
			} else {
				return Torque_API_Responses::Failure_Response();
			}

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
