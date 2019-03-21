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
		$post->meta = $this->prepare_meta( $post->ID );

		$post->thumbnail = get_the_post_thumbnail_url($post->ID, 'large');

		$post->post_type_label = $this->get_post_type_label($post->post_type);

		$post->permalink = get_post_permalink($post->ID);

		$terms = wp_get_post_terms($post->ID, array_keys($this->taxonomies));
		$post->terms = array_map(function($term) { return $term->name; }, $terms);

		return $post;
	}

	private function prepare_meta( $post_id ) {
		$wp_keys = array_filter(
			get_post_custom_keys($post_id),
			function($meta_key) {
				// hide private meta
				return $meta_key[0] !== '_';
			}
		);

		$wp_meta = [];
		foreach ($wp_keys as $key) {
			$meta = get_post_meta($post_id, $key, true);

			if (is_array($meta)) {
				foreach ($meta as $arr_key => $value) {
					$meta_key = $key.'_'.$arr_key;
					$wp_meta[$meta_key] = $value;
				}
			} else {
				$wp_meta[$key] = $meta;
			}
		}

		$acf_meta = get_fields($post_id);
		$acf_meta = $acf_meta ? $acf_meta : array();

		return $wp_meta + $acf_meta;
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
