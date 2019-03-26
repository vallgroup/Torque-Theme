<?php

require_once( get_template_directory() . '/api/responses/torque-api-responses-class.php');
require_once( get_template_directory() . '/includes/validation/torque-validation-class.php');

class Torque_Filtered_Loop_Posts_Controller {

	public static function get_posts_args() {
		return array(
      'post_type' => array(
        'validate_callback' => array( 'Torque_Validation', 'string' ),
      ),
			'year'	=> array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
			'monthnum'	=> array(
        'validate_callback' => array( 'Torque_Validation', 'int' ),
      ),
    );
	}

	protected $request = null;

	function __construct( $request ) {

		$this->request = $request;
		$this->taxonomies = get_taxonomies(array('public' => true),'names');
	}

	public function get_posts() {
		try {
			$query_args = $this->build_query_from_params($this->request->get_params());

			$query = new WP_Query( $query_args );

			if ($query->have_posts()) {
				foreach ($query->posts as &$post) {
					$this->setup_post_shape($post);
				}

        return Torque_API_Responses::Success_Response( array(
          'posts'	=> $query->posts
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'posts'	=> []
			));

		} catch (Exception $e) {
			return Torque_API_Responses::Error_Response( $e );
		}
	}

	private function build_query_from_params($params) {
		$query = array();

		foreach ($params as $key => $value) {
			// meta query params
			if (substr($key, 0 ,5) === 'meta_') {
				$meta_key = substr($key, 5);

				if (substr($meta_key, 0, 6) === 'field_') {
					// is acf key, need to get the field name
					$field = get_field_object( $meta_key );
					$meta_key = $field['name'];
				}

				$query['meta_query'][] = array(
					'key'	  => $meta_key,
					'value'	=> $value
				);
				continue;
			}

			// tax query params
			if (substr($key, 0 ,4) === 'tax_') {
				$tax_slug = substr($key, 4);

				$query['tax_query'][] = array(
					'taxonomy' => $tax_slug,
					'terms'    => intval($value),
				);
				continue;
			}

			// other params
			$query[$key] = $value;
		}

		return $query;
	}

	private function setup_post_shape( &$post ) {
		$post->meta = $this->prepare_meta( $post->ID );

		$post->thumbnail = get_the_post_thumbnail_url($post->ID, 'large');

		$post->permalink = get_post_permalink($post->ID);

		$post->terms = wp_get_post_terms($post->ID, array_keys($this->taxonomies));
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
}
