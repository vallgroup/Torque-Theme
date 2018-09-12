<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Careers_CPT {

	/**
	 * Holds the careers cpt object
	 *
	 * @var Object
	 */
	protected $careers = null;

	/**
	 * Holds the labels needed to build the careers custom post type.
	 *
	 * @var array
	 */
	public static $careers_labels = array(
			'singular'       => 'Career',
			'plural'         => 'Careers',
			'slug'           => 'torque-career',
			'post_type_name' => 'torque_career',
	);

	/**
	 * Holds options for the careers custom post type
	 *
	 * @var array
	 */
	protected $careers_options = array(
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
			new PremiseCPT( self::$careers_labels, $this->careers_options );
		}
	}
}

?>
