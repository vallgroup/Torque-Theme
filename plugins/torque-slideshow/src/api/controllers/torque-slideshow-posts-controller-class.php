<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Slideshow_Posts_Controller {

	public static function get_posts_args() {
		return array(
      'ids' => array(
        'validate_callback' => array( 'Torque_Validation', 'arr' ),
      ),
    );
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
	}

	public function get_posts() {
		try {
			$query = new WP_Query( array (
				'post_type'			=> 'any',
				'post__in'			=> $this->request['ids']
			) );

			if ($query->have_posts()) {
				$posts = [];

				foreach ($query->posts as $post) {
					$post->meta =
					array_filter(
						array_merge(
							// get all meta from both WP and ACF
							get_post_meta($post->ID),
							get_fields($post->ID)
						),
						function($meta_key) {
							// hide private meta
							return $meta_key[0] !== '_';
						},
						ARRAY_FILTER_USE_KEY
					);

					$post->thumbnail = get_the_post_thumbnail_url($post->ID, 'large');

					$posts[] = $post;
				}

        return Torque_API_Responses::Success_Response( array(
          'data'	=> $posts
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'data'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}
}
