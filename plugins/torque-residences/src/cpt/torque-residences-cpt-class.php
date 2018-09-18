<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Residences_CPT {

	/**
	 * Holds the residences cpt object
	 *
	 * @var Object
	 */
	protected $residences = null;

	/**
	 * Holds the labels needed to build the residences custom post type.
	 *
	 * @var array
	 */
	public static $residences_labels = array(
			'singular'       => 'Residence',
			'plural'         => 'Residences',
			'slug'           => 'torque-residences',
			'post_type_name' => 'torque_residences',
	);

	/**
	 * Holds options for the residences custom post type
	 *
	 * @var array
	 */
	protected $residences_options = array(
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
		'menu_icon'           => 'dashicons-admin-multisite',
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$residences_labels, $this->residences_options );
		}

		pwp_add_metabox(
			'Residence Website',
			array( self::$residences_labels['post_type_name'] ),
			array(
				array(
					'type'    => 'text',
					'context' => 'post',
					'name'    => 'residence_website_url',
					'label'   => 'Website URL',
				),
			),
			'residence_website_url'
		);
	}
}

?>
