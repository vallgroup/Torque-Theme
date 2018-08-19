<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Building_Facts_CPT {

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( array(
				'plural'         => 'Building Facts',
				'singular'       => 'Building Fact',
				'post_type_name' => 'torque_building_fact',
				'slug'           => 'torque-building-fact'
			), array(
				'supports'             => array( 'title', 'editor' ),
				'public'               => false,
				'show_ui'              => true,
				'show_in_rest'         => true,
				'menu_icon'           => 'dashicons-portfolio',
			));
		}
	}
}

?>
