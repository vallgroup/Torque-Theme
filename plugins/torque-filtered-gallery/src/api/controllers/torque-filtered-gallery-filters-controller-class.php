<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Filtered_Gallery_Filters_Controller {

	public static function get_filter_acf_select_args() {
		return array(
      'field_id' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
      'gallery_id' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
    );
	}

	protected $request = null;
	protected $params = array();

	function __construct( $request ) {
		$this->request = $request;
		$this->params = $this->request->get_params();
	}

	public function get_filter_acf_select() {
		try {

			// $field_options = get_field( $this->params['field_id'], $this->params['gallery_id'] );
			// var_dump( '$field', $field );

			$choices = $this->build_choices( $this->params['field_id'], $this->params['gallery_id'] );

			if ( $choices ) {
        return Torque_API_Responses::Success_Response( array(
          'choices'	=> $choices
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'choices'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	private function build_choices( $field_id, $gallery_id ) {
		$choices = array();

		// if has rows
		if ( have_rows( $field_id, $gallery_id ) ) :
			// while has rows
			while ( have_rows( $field_id, $gallery_id ) ) : the_row();
				// vars
				$label = get_sub_field( 'category' );
				$value = $label
					? strtolower( str_replace( array( ' ', ',', '.', '_' ), '-', $label ) )
					: null;

				// append to choices
				if ( $label ) {
					$choices[$value] = $label;
				}

			endwhile;
		endif;

		return $choices;
	}
}
