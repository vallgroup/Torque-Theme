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

	private $post_type_labels = array();

	private $taxonomies = [];

	function __construct( $request ) {
		$this->request = $request;
		$this->taxonomies = get_taxonomies(array('public' => true),'names');
	}

	public function get_posts() {
		try {
			$query = new WP_Query( array (
				'post_type'			=> 'any',
				'post__in'			=> $this->request['ids']
			) );

			if ($query->have_posts()) {
				foreach ($query->posts as &$post) {
					$this->setup_post_shape($post);
				}

        return Torque_API_Responses::Success_Response( array(
          'data'	=> $query->posts
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'data'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	private function setup_post_shape( $post ) {
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

		$post->post_type_label = $this->get_post_type_label($post->post_type);

		$post->permalink = get_post_permalink($post->ID);

		$terms = wp_get_post_terms($post->ID, array_keys($this->taxonomies));
		$post->terms = array_map(function($term) { return $term->name; }, $terms);

		return $post;
	}

	private function get_post_type_label( $post_type ) {
		if ($this->post_type_labels[$post_type]) {
			return $this->post_type_labels[$post_type];
		}

		$post_type = get_post_type_object( $post_type );
		$post_type_label = $post_type->label;

		$this->post_type_labels[$post_type] = $post_type_label;
		return $post_type_label;
	}
}
