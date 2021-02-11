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

			// var_dump( $query->have_posts() );

			$has_next_page = $this->has_next_page( $query_args );

			if ($query->have_posts()) {
				foreach ($query->posts as &$post) {
					$this->setup_post_shape($post);
				}

        return Torque_API_Responses::Success_Response( array(
          'posts'	=> $query->posts,
					'has_next_page' => $has_next_page
        ) );
			}

			return Torque_API_Responses::Failure_Response( array(
				'posts'	=> [],
				'has_next_page' => false
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
				if ($value === "0") {
					continue;
				}
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
				if ($value === "0") {
					continue;
				}
				$tax_slug = substr($key, 4);
				$operator = 'IN';
				$field = 'term_id';

				// var_dump( $value );

				// check if tax query value is an array (multi-select), and format the value accordingly
				if ( false !== strpos( $value, ',' ) ) {
					// tidy values
					$value = explode( 
						',', 
						str_replace( 
							' ', 
							'', 
							$value
						)
					);
						
					$query['tax_query'] = array(
						'relation'	=> 'OR'
					);

					// create a new tax_query array for each term ID
					foreach($value as $v) {
						$query['tax_query'][] = array(
							'taxonomy' => $tax_slug,
							'field'    => $field,
							'terms'    => intval($v),
							'operator' => $operator,
						);
					}
				} else {
					// create tax_query for the term ID
					$query['tax_query'][] = array(
						'taxonomy' => $tax_slug,
						'field'    => $field,
						'terms'    => intval($value),
						'operator' => $operator,
					);
				}

				continue;
			}

			// other params
			$query[$key] = $value;
		}

		// var_dump( $query );

		return $query;
	}

	private function setup_post_shape( &$post ) {
		$post->meta = $this->prepare_meta( $post->ID );

		$post->thumbnail = get_the_post_thumbnail_url($post->ID, 'large');

		$post->permalink = get_post_permalink($post->ID);

		$post->terms = wp_get_post_terms($post->ID, array_keys($this->taxonomies));

		$post->acf = function_exists( 'get_fields' ) 
			? get_fields( $post->ID, false ) 
			: null;
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

	private function has_next_page( $query_args ) {
		if ( 
			!isset( $query_args['posts_per_page'] ) 
			|| !$query_args['posts_per_page'] 
			|| $query_args['posts_per_page'] == -1 
		) {
			return false;
		}

		$next_page = intval($query_args['paged']) + 1;
		$query_args['paged'] = $next_page;

		$query = new WP_Query( $query_args );
		return $query->have_posts();
	}
}
