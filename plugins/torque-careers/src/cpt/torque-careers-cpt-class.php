<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Careers_CPT {

	/**
	 * Holds the example cpt object
	 *
	 * @var Object
	 */
	protected $example = null;

	/**
	 * Holds the labels needed to build the example custom post type.
	 *
	 * @var array
	 */
	public static $example_labels = array(
			'singular'       => 'Career',
			'plural'         => 'Careers',
			'slug'           => 'torque-career',
			'post_type_name' => 'torque_career',
	);

	/**
	 * Holds options for the example custom post type
	 *
	 * @var array
	 */
	protected $example_options = array(
		'supports' => array(
			'title',
			'editor',
		),
		'menu_icon'           => 'dashicons-welcome-learn-more',
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$example_labels, $this->example_options );
		}
	}
}

?>
