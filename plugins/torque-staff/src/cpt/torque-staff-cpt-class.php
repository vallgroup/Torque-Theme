<?php
/**
 * Register the torque cpt and it's meta boxes
 */
class Torque_Staff_CPT {

	public static $STAFF_METABOXES_FILTER_HOOK = 'torque_staff_exclude_metaboxes';

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

		// needs to run after theme setup so we can apply the filter in functions.php
		add_action( 'after_setup_theme', array($this, 'register_metaboxes') );
	}

	public function register_metaboxes() {
		// can hide metaboxes by passing an array of strings.
		$exclude_metaboxes = apply_filters( self::$STAFF_METABOXES_FILTER_HOOK, array() );

		// potential metaboxes
		$maybe_metaboxes = array(
			'role' => array(
				'type'    => 'text',
				'context' => 'post',
				'name'    => '[role]',
				'label'   => 'Role',
			),
			'tel' => array(
				'type'    => 'text',
				'context' => 'post',
				'name'    => '[tel]',
				'label'   => 'Telephone',
			),
			'email' => array(
				'type'    => 'text',
				'context' => 'post',
				'name'    => '[email]',
				'label'   => 'Email',
			),
		);

		$metaboxes = array(
			'name_prefix'		=> 'staff_meta'
		);

		// if metabox isnt hidden then add it to metaboxes
		foreach ($maybe_metaboxes as $metabox_slug => $metabox) {
			if ( in_array( $metabox_slug, $exclude_metaboxes ) ) {
				continue;
			}

			$metaboxes[] = $metabox;
		}

		// add metaboxes
		pwp_add_metabox(
			'Staff Meta',
			array( self::$staff_labels['post_type_name'] ),
			$metaboxes,
			'staff_meta'
		);
	}
}

?>
