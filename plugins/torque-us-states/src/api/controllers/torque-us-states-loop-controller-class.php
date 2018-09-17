<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_US_States_Loop_Controller {

	public static function get_posts_args() {
		return array(
			'post_type'				=> array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
			'per_page'				=> array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
			'paged'						=> array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
			'state'					  => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
		);
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_posts() {
		try {
			$query = new WP_Query( array(
				'post_type'				=> $this->request['post_type'],
				'posts_per_page'	=> $this->request['per_page'] ?? -1,
				'paged'						=> $this->request['paged'],
				'meta_key'				=> 'assigned_state',
				'meta_value'			=> $this->request['state']
			));

			$posts = $query->posts;

			if ($posts && sizeof($posts)) {
				// add extra properties to post
				foreach ($posts as &$post) {
					$post->featured_image = get_the_post_thumbnail_url($post);
				}

        return Torque_API_Responses::Success_Response( array(
          'posts'	=> $posts
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'posts'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
