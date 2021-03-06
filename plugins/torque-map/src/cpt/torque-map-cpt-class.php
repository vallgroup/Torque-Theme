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

		pwp_add_metabox( 'Map Details', array( 'torque_map' ), array(
			'name_prefix' => 'torque_map',
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[center]',
				'label'       => 'Map Center',
				'placeholder' => 'Address, Zip Code or Place',
			),
			array(
				'context'     => 'post',
				'type'        => 'number',
				'name'        => '[zoom]',
				'label'       => 'Zoom',
				'placeholder' => '12',
			),
			array(
				'context'     => 'post',
				'type'        => 'wp_media',
				'name'        => '[center_marker][url]',
				'label'       => 'Center Marker Icon',
				'placeholder' => 'Enter icon url or click upload button',
			),
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[center_marker][size]',
				'label'       => 'Center Marker Size',
				'placeholder' => '20,32',
			),
			array(
				'context'     => 'post',
				'type'        => 'textarea',
				'name'        => '[center_marker][infowindow]',
				'label'       => 'Center Marker Info Window',
				'placeholder' => '<h3>My Fancy Title</h3>',
			),
		), 'torque_map');

		$this->maybe_add_pois();

		pwp_add_metabox( 'Map Styles', array( 'torque_map' ), array(
			array(
				'context'     => 'post',
				'type'        => 'textarea',
				'name'        => 'map_styles',
				'label'       => 'Create your style with https://snazzymaps.com/, then copy the entire "JavaScript style array" output into this box',
				'placeholder' => '',
			),
		), 'map_styles');
	}

	public function maybe_add_pois() {

		$number_of_pois = apply_filters( self::$POIS_ALLOWED_FILTER, 0 );
		$manual_pois = (bool) apply_filters( self::$POIS_MANUAL_FILTER, false );

		if ($number_of_pois > 0) {
			pwp_add_metabox( 'Point of Interest Section Title', array( 'torque_map' ), array(
				array(
					'context'     => 'post',
					'type'        => 'text',
					'name'        => 'pois_section_title',
					'label'       => 'Section Title',
					'placeholder' => 'Click a Category',
				),
			), 'pois_section_title');
		}

		for ($i=0; $i < $number_of_pois; $i++) {
			if ( $manual_pois ) {
				$this->manual_poi_mb( $i );
			} else {
				$this->poi_mb( $i );
			}
		}
	}

	public function poi_mb( $n = 0 ) {

		$option_name = 'torque_map_pois_'.$n;
		$mb_title = 'Points Of Interest '.($n + 1);

		pwp_add_metabox( $mb_title, array( 'torque_map' ), array(
			'name_prefix' => $option_name,
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[name]',
				'label'       => 'Name',
				'placeholder' => 'Hospitals',
			),
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[keyword]',
				'label'       => 'Keyword',
				'placeholder' => 'hospitals, clinics, urgent care',
			),
			array(
				'context'     => 'post',
				'type'        => 'wp_media',
				'name'        => '[marker][url]',
				'label'       => 'Marker To Use For This POI',
				'placeholder' => 'Enter icon url or click upload button',
			),
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[marker][size]',
				'label'       => 'Marker Size',
				'placeholder' => '20,32',
			),
			array(
				'context'     => 'post',
				'type'        => 'checkbox',
				'name'        => '[preload]',
				'label'       => 'Pre-load this POI',
			),
		), $option_name);
	}

	public function manual_poi_mb( $n = 0 ) {

		$option_name = 'torque_map_manual_pois_'.$n;
		$mb_title = 'Point Of Interest '.($n + 1);

		pwp_add_metabox( $mb_title, array( 'torque_map' ), array(
			'name_prefix' => $option_name,
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[name]',
				'label'       => 'Name',
				'placeholder' => 'Hospitals',
			),
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[location]',
				'label'       => 'Location',
				'placeholder' => 'Address or Lat, Long coordinates',
			),
			array(
				'context'     => 'post',
				'type'        => 'textarea',
				'name'        => '[marker][infowindow]',
				'label'       => 'Marker Info Window',
				'placeholder' => '<h3>My Fancy Title</h3>',
			),
			array(
				'context'     => 'post',
				'type'        => 'wp_media',
				'name'        => '[marker][url]',
				'label'       => 'Marker To Use For This POI',
				'placeholder' => 'Enter icon url or click upload button',
			),
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[marker][size]',
				'label'       => 'Marker Size',
				'placeholder' => '20,32',
			),
			array(
				'context'     => 'post',
				'type'        => 'checkbox',
				'name'        => '[preload]',
				'label'       => 'Pre-load this POI',
			),
		), $option_name);
	}
}

?>
