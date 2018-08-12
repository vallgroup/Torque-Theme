<?php
/**
 * Register the torque map cpt and it's meta boxes
 */
class Toruqe_Map_CPT {

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
		), 'torque_map');

		$this->maybe_add_pois();
	}

	public function maybe_add_pois() {
		/**
		 * Filters the number of pois allowed for the map
		 * Allows theme to register number of pois it uses
		 * in design
		 *
		 * @var int
		 */
		$number_of_pois = apply_filters( 'torque_map_pois_allowed', 0 );
		for ($i=0; $i < $number_of_pois; $i++) {
			$this->poi_mb( $i );
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
		), $option_name);
	}
}

?>