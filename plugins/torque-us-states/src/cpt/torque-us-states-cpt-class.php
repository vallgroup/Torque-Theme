<?php
/**
 * Register the torque cpt and it's meta boxes
 */

require_once( Torque_US_States_PATH . 'includes/torque-us-states-functions-class.php');

class Torque_US_States_CPT {

	// filter handle for choosing which post types to display the state selector on
	public static $POST_TYPES_STATE_ASSIGNER_FILTER_HANDLE = 'torque_us_states_post_types_state_assigner';

	// option handle for saving the array of post types
	public static $POST_TYPES_WITH_STATE_ASSIGNER_OPTION_HANDLE = 'torque_us_states_post_types_with_state_assigner';

	/**
	 * Holds the us_states cpt object
	 *
	 * @var Object
	 */
	protected $us_states = null;

	/**
	 * Holds the labels needed to build the us_states custom post type.
	 *
	 * @var array
	 */
	public static $us_states_labels = array(
			'singular'       => 'US State',
			'plural'         => 'US States',
			'slug'           => 'torque-us-state',
			'post_type_name' => 'torque_us_state',
	);

	/**
	 * Holds options for the us_states custom post type
	 *
	 * @var array
	 */
	protected $us_states_options = array(
		'supports' => array(
			'title',
			'editor',
		),
		'menu_icon'           => 'dashicons-location-alt',
	);

	/**
	 * register our post type and meta boxes
	 */
	public function __construct() {
		if ( class_exists( 'PremiseCPT' ) ) {
			new PremiseCPT( self::$us_states_labels, $this->us_states_options );
		}

		pwp_add_metabox(
			array(
				'title'   => 'Assign a State',
				'context' => 'side',
				'priority' => 'high',
			),
			array( self::$us_states_labels['post_type_name'] ),
			array(
				array(
					'type'    => 'select',
					'context' => 'post',
					'name'    => 'state_code',
					'label'   => 'Unassigned States',
					'options'	=> $this->get_unassigned_state_options()
				),
			),
			'state_code'
		);

		// needs to run after theme setup so we can apply the filter in functions.php
		// and so we can be sure the other post types are set up
		add_action( 'after_setup_theme', array($this, 'add_state_assignment_metabox_to_other_post_types') );
	}

	public function add_state_assignment_metabox_to_other_post_types() {
		//
		// we want to get passed an array of post type names
		// to add the state assignment metabox to
		//
		$post_types = apply_filters( self::$POST_TYPES_STATE_ASSIGNER_FILTER_HANDLE, array() );

		// update option to keep track of which post types can be assigned a state post
		$this->save_post_types_with_state_assigner_option( $post_types );

		if ( ! sizeof($post_types) ) {
			return;
		}

		foreach ($post_types as $post_type) {
			pwp_add_metabox(
				'Assign to a US State',
				array( $post_type ),
				array(
					array(
						'type'    => 'select',
						'context' => 'post',
						'name'    => 'assigned_state',
						'label'   => 'Assigned States',
						'options'	=> $this->get_assigned_state_options()
					),
				),
				'assigned_state'
			);
		}
	}

	private function save_post_types_with_state_assigner_option( $post_types_with_state_assigner ) {
		$post_types = array();

		$post_types_db = get_post_types(
			array(
				'public'		=> true
			),
			'objects'
		);

		foreach ($post_types_with_state_assigner as $post_type) {
			if ( isset( $post_types_db[$post_type] ) ) {
				$post_types[$post_type] = $post_types_db[$post_type]->label;
			}
		}

		update_option( self::$POST_TYPES_WITH_STATE_ASSIGNER_OPTION_HANDLE, $post_types );
	}

	private function get_unassigned_state_options() {
		$unassigned_states = Torque_US_States_Functions::get_unassigned_states();

		// we need to add the current post's selected state back in to the dropdown
		if ( isset($_GET['post']) ) {

			$assigned_state_code = Torque_US_States_Functions::get_state_post_assigned_state_code( $_GET['post'] );

			if ( $assigned_state_code ) {
				$unassigned_states[$assigned_state_code] = Torque_US_States_Functions::$states[$assigned_state_code];
			}
		}


		return array_flip($unassigned_states);
	}

	private function get_assigned_state_options() {
		return  array_flip(Torque_US_States_Functions::get_assigned_states());
	}
}

?>
