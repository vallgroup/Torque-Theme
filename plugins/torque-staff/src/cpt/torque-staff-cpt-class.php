<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Staff_CPT {

	/**
	 * Holds the staff cpt object
	 *
	 * @var Object
	 */
	protected $staff = null;

	/**
	 * Holds the labels needed to build the staff custom post type.
	 *
	 * @var array
	 */
	public static $staff_labels = array(
			'singular'       => 'Staff',
			'plural'         => 'Staff',
			'slug'           => 'torque-staff',
			'post_type_name' => 'torque_staff',
	);

	/**
	 * Holds options for the staff custom post type
	 *
	 * @var array
	 */
	protected $staff_options = array(
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
		'menu_icon'           => 'dashicons-businessman',
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$staff_labels, $this->staff_options );
		}

		pwp_add_metabox(
			'Staff Meta',
			array( self::$staff_labels['post_type_name'] ),
			array(
				'name_prefix' => 'staff_meta',
				array(
					'type'    => 'text',
					'context' => 'post',
					'name'    => '[role]',
					'label'   => 'Role',
				),
				array(
					'type'    => 'text',
					'context' => 'post',
					'name'    => '[tel]',
					'label'   => 'Telephone',
				),
				array(
					'type'    => 'text',
					'context' => 'post',
					'name'    => '[email]',
					'label'   => 'Email',
				),
			),
			'staff_meta'
		);
	}
}

?>
