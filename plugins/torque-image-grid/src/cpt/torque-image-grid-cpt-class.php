<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Image_Grid_CPT {

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
			'singular'       => 'Image Grid',
			'plural'         => 'Image Grids',
			'slug'           => 'torque-image-grid',
			'post_type_name' => 'torque_image_grid',
	);

	/**
	 * Holds options for the example custom post type
	 *
	 * @var array
	 */
	protected $example_options = array(
		'supports' => array(
			'title',
			'editor'
		),
		'menu_icon'           => 'dashicons-grid-view',
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$example_labels, $this->example_options );
		}

		// pwp_add_metabox(
		// 	'Example Meta',
		// 	array( self::$example_labels['post_type_name'] ),
		// 	array(
		// 		'name_prefix' => 'example_meta',
		// 		array(
		// 			'type'    => 'text',
		// 			'context' => 'post',
		// 			'name'    => '[tel]',
		// 			'label'   => 'Telephone',
		// 		),
		// 		array(
		// 			'type'    => 'text',
		// 			'context' => 'post',
		// 			'name'    => '[email]',
		// 			'label'   => 'Email',
		// 		),
		// 	),
		// 	'example_meta'
		// );
	}
}

?>
