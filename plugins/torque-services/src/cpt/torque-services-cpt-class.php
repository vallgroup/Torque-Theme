<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Services_CPT {

	/**
	 * Holds the services cpt object
	 *
	 * @var Object
	 */
	protected $services = null;

	/**
	 * Holds the labels needed to build the services custom post type.
	 *
	 * @var array
	 */
	public static $services_labels = array(
			'singular'       => 'Service',
			'plural'         => 'Services',
			'slug'           => 'torque-services',
			'post_type_name' => 'torque_services',
	);

	/**
	 * Holds options for the services custom post type
	 *
	 * @var array
	 */
	protected $services_options = array(
		'supports' => array(
			'title',
			'editor',
		),
		'menu_icon'           => 'dashicons-businessman',
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$services_labels, $this->services_options );
		}
	}
}

?>
