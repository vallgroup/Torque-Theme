<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class <torque_plugin_class_name>_CPT {

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( array(
				'plural'         => 'Examples',
				'singular'       => 'Example',
				'post_type_name' => 'torque_example',
				'slug'           => 'torque-example'
			), array(
				'supports'             => array( 'title' ),
				'public'               => false,
				'show_ui'              => true,
				'show_in_rest'         => true,
			));

			add_action( 'init', array( $this, 'register_mb' ) );
		}
	}

	/**
	 * add the metaboxes to the post type
	 *
	 * @return void
	 */
	public function register_mb() {

		pwp_add_metabox( 'Example Metabox', array( 'torque_example_mb' ), array(
			'name_prefix' => 'torque_example_mb',
			array(
				'context'     => 'post',
				'type'        => 'text',
				'name'        => '[example_field]',
				'label'       => 'Example Field',
				'placeholder' => 'Address, Zip Code or Place',
			),
			array(
				'context'     => 'post',
				'type'        => 'wp_media',
				'name'        => '[example_image_url]',
				'label'       => 'Example Image',
				'placeholder' => 'Enter icon url or click upload button',
			),
		), 'torque_example_mb');

		// add more metaboxes here
	}
}

?>
