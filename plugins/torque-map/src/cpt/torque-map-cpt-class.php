<?php
/**
 * Register the torque map cpt and it's meta boxes
 */
class Torque_Map_CPT {

	/**
	 * Filters the number of pois allowed for the map
	 * Allows theme to register number of pois it uses
	 * in design
	 *
	 * @var int
	 */
	public static $POIS_ALLOWED_FILTER = 'torque_map_pois_allowed';

	/**
	 * Filters whether to display the manual POIs or the
	 * dynamic ones. By default, we display the dynamic.
	 *
	 * @var bool
	 */
	public static $POIS_MANUAL_FILTER = 'torque_map_manual_pois';

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( array(
				'plural'         => 'Maps',
				'singular'       => 'Map',
				'post_type_name' => 'torque_map',
				'slug'           => 'torque-map'
			), array(
				'supports'             => array( 'title' ),
				'public'               => false,
				'show_ui'              => true,
				'show_in_rest'         => true,
			));
			// must run at init, otherwise the filter for pois will not work.
			add_action( 'init', array( $this, 'register_mb' ) );
			add_action('acf/init', array( $this, 'register_acf_fields' ) );
		}
	}

	/**
	 * output the shortcode string
	 *
	 * @return string the shortcode string
	 */
	public function output_sc_string() {
		global $post;
		?>
		<p>To use this map anywhere on your site, copy and paste this shortcode: <code>[torque_map map_id="<?php echo $post->ID; ?>"]</code></p>
		<?php
	}

	/**
	 * add the metaboxes to the post type
	 *
	 * @return void
	 */
	public function register_mb() {

		pwp_add_metabox( array(
			'title' => 'The Shortcode',
			'callback' => array( $this, 'output_sc_string' ),
		), array( 'torque_map' ), '', '' );

		// pwp_add_metabox( 'Map Details', array( 'torque_map' ), array(
		// 	'name_prefix' => 'torque_map',
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'text',
		// 		'name'        => '[center]',
		// 		'label'       => 'Map Center',
		// 		'placeholder' => 'Address, Zip Code or Place',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'number',
		// 		'name'        => '[zoom]',
		// 		'label'       => 'Zoom',
		// 		'placeholder' => '12',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'wp_media',
		// 		'name'        => '[center_marker][url]',
		// 		'label'       => 'Center Marker Icon',
		// 		'placeholder' => 'Enter icon url or click upload button',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'text',
		// 		'name'        => '[center_marker][size]',
		// 		'label'       => 'Center Marker Size',
		// 		'placeholder' => '20,32',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'textarea',
		// 		'name'        => '[center_marker][infowindow]',
		// 		'label'       => 'Center Marker Info Window',
		// 		'placeholder' => '<h3>My Fancy Title</h3>',
		// 	),
		// ), 'torque_map');

		$this->maybe_add_pois();

		// pwp_add_metabox( 'Map Styles', array( 'torque_map' ), array(
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'textarea',
		// 		'name'        => 'map_styles',
		// 		'label'       => 'Create your style with https://snazzymaps.com/, then copy the entire "JavaScript style array" output into this box',
		// 		'placeholder' => '',
		// 	),
		// ), 'map_styles');
	}

	public function maybe_add_pois() {

		// $number_of_pois = apply_filters( self::$POIS_ALLOWED_FILTER, 0 );
		// $manual_pois = (bool) apply_filters( self::$POIS_MANUAL_FILTER, false );
		//
		// if ($number_of_pois > 0) {
		// 	pwp_add_metabox( 'Point of Interest Section Title', array( 'torque_map' ), array(
		// 		array(
		// 			'context'     => 'post',
		// 			'type'        => 'text',
		// 			'name'        => 'pois_section_title',
		// 			'label'       => 'Section Title',
		// 			'placeholder' => 'Click a Category',
		// 		),
		// 	), 'pois_section_title');
		// }
		//
		// for ($i=0; $i < $number_of_pois; $i++) {
		// 	if ( $manual_pois ) {
		// 		$this->manual_poi_mb( $i );
		// 	} else {
		// 		$this->poi_mb( $i );
		// 	}
		// }
	}

	public function poi_mb( $n = 0 ) {

		$option_name = 'torque_map_pois_'.$n;
		$mb_title = 'Points Of Interest '.($n + 1);

		// pwp_add_metabox( $mb_title, array( 'torque_map' ), array(
		// 	'name_prefix' => $option_name,
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'text',
		// 		'name'        => '[name]',
		// 		'label'       => 'Name',
		// 		'placeholder' => 'Hospitals',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'text',
		// 		'name'        => '[keyword]',
		// 		'label'       => 'Keyword',
		// 		'placeholder' => 'hospitals, clinics, urgent care',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'wp_media',
		// 		'name'        => '[marker][url]',
		// 		'label'       => 'Marker To Use For This POI',
		// 		'placeholder' => 'Enter icon url or click upload button',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'text',
		// 		'name'        => '[marker][size]',
		// 		'label'       => 'Marker Size',
		// 		'placeholder' => '20,32',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'checkbox',
		// 		'name'        => '[preload]',
		// 		'label'       => 'Pre-load this POI',
		// 	),
		// ), $option_name);
	}

	public function manual_poi_mb( $n = 0 ) {

		// $option_name = 'torque_map_manual_pois_'.$n;
		// $mb_title = 'Point Of Interest '.($n + 1);
		//
		// pwp_add_metabox( $mb_title, array( 'torque_map' ), array(
		// 	'name_prefix' => $option_name,
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'text',
		// 		'name'        => '[name]',
		// 		'label'       => 'Name',
		// 		'placeholder' => 'Hospitals',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'text',
		// 		'name'        => '[location]',
		// 		'label'       => 'Location',
		// 		'placeholder' => 'Address or Lat, Long coordinates',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'textarea',
		// 		'name'        => '[marker][infowindow]',
		// 		'label'       => 'Marker Info Window',
		// 		'placeholder' => '<h3>My Fancy Title</h3>',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'wp_media',
		// 		'name'        => '[marker][url]',
		// 		'label'       => 'Marker To Use For This POI',
		// 		'placeholder' => 'Enter icon url or click upload button',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'text',
		// 		'name'        => '[marker][size]',
		// 		'label'       => 'Marker Size',
		// 		'placeholder' => '20,32',
		// 	),
		// 	array(
		// 		'context'     => 'post',
		// 		'type'        => 'checkbox',
		// 		'name'        => '[preload]',
		// 		'label'       => 'Pre-load this POI',
		// 	),
		// ), $option_name);
	}

	public function register_acf_fields() {
		if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5e4ab89445e31',
	'title' => 'Map Details',
	'fields' => array(
		array(
			'key' => 'field_5e4ab8a32e516',
			'label' => 'Map Center',
			'name' => 'center',
			'type' => 'text',
			'instructions' => 'Enter the address you would like to use as the center of the map when the map loads. This field is required and it can be a full address, a zip code, or city.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '70',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Chicao, IL',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5e4abefc2e517',
			'label' => 'Initial Zoom',
			'name' => 'zoom',
			'type' => 'range',
			'instructions' => 'Select the initial zoom level at which you would like the map to load.
Defaults to 12.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'default_value' => 12,
			'min' => 0,
			'max' => 18,
			'step' => 1,
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_5e4abffc2e518',
			'label' => 'Marker',
			'name' => 'marker',
			'type' => 'group',
			'instructions' => 'The marker is the pin used for the map center. If you do not include a pin, no marker will be displayed for the map center.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_5e4b21f22e519',
					'label' => 'Image',
					'name' => 'url',
					'type' => 'image',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'preview_size' => 'thumbnail',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array(
					'key' => 'field_5e4b220f2e51a',
					'label' => 'size',
					'name' => 'size',
					'type' => 'text',
					'instructions' => 'Enter the size that you want the map pin to display at, as `width,height`.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '20,32',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e4b6c032e51b',
					'label' => 'Info Window',
					'name' => 'infowindow',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'basic',
					'media_upload' => 1,
					'delay' => 0,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'torque_map',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5e4b6f105ef0a',
	'title' => 'Map POIs',
	'fields' => array(
		array(
			'key' => 'field_5e4b78d3f4113',
			'label' => 'Section Title',
			'name' => 'section_title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5e4b6f1aab091',
			'label' => 'POIs',
			'name' => 'pois',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Add POI',
			'sub_fields' => array(
				array(
					'key' => 'field_5e4b6fbbab092',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'Name This POI',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e4b7007ab093',
					'label' => 'Keyword',
					'name' => 'keyword',
					'type' => 'text',
					'instructions' => 'Enter keyword(s) separated by commas.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e4b75adab094',
					'label' => 'Marker',
					'name' => 'marker',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5e4b7605ab095',
							'label' => 'Image',
							'name' => 'url',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '70',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'url',
							'preview_size' => 'thumbnail',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array(
							'key' => 'field_5e4b7616ab096',
							'label' => 'Size',
							'name' => 'size',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '30',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '20,32',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
				),
				array(
					'key' => 'field_5e4b7652ab097',
					'label' => 'Pre-load this POI',
					'name' => 'preload',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => '',
					'default_value' => 0,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_5e4b76b794a2b',
					'label' => 'Pre-Set POIs',
					'name' => 'preset_pois',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'collapsed' => '',
					'min' => 0,
					'max' => 0,
					'layout' => 'block',
					'button_label' => 'Add POI',
					'sub_fields' => array(
						array(
							'key' => 'field_5e4b76f294a2c',
							'label' => 'Title',
							'name' => 'title',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5e4b771594a2d',
							'label' => 'Location',
							'name' => 'location',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5e4b772394a2e',
							'label' => 'Infowindow',
							'name' => 'infowindow',
							'type' => 'textarea',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'maxlength' => '',
							'rows' => '',
							'new_lines' => '',
						),
						array(
							'key' => 'field_5e4be37723a0c',
							'label' => 'Latitude',
							'name' => 'latitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5e4be39a23a0d',
							'label' => 'Longitude',
							'name' => 'longitude',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '50',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'torque_map',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5e4b6cf992bd7',
	'title' => 'Map Styles',
	'fields' => array(
		array(
			'key' => 'field_5e4b6d02950e0',
			'label' => 'Map Styles',
			'name' => 'map_styles',
			'type' => 'textarea',
			'instructions' => 'Go to <a href="https://mapstyle.withgoogle.com/" target="_blank" rel="noopener noreferrer">Map Styles</a> to change the way this map looks. Copy and paste styles into this text box.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'torque_map',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
	}
}

?>
