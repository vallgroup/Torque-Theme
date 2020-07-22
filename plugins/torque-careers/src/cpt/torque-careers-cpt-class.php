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
			'slug'           => 'career',
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
		'menu_position'				=> 20
	);

	/**
	 * register our post type and meta boxes
	 */
	function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$careers_labels, $this->careers_options );
		}
		// register ACF fields
		add_action('acf/init', array($this, 'add_career_acf_metaboxes'));
	}

	public function add_career_acf_metaboxes() {
		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5f17762af03ae',
				'title' => 'Career Form Settings',
				'fields' => array(
					array(
						'key' => 'field_5f1776b042209',
						'label' => 'Notification Email',
						'name' => 'notification_email',
						'type' => 'email',
						'instructions' => 'Please enter the email address for which you\'d like to receive notifications of Career submissions.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'torque_career',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));
			
			endif;
	}
}

?>
