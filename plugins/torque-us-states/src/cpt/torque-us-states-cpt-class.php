<?php
/**
 * Register the torque cpt and it's meta boxes
 */

require_once( Torque_US_States_PATH . 'includes/torque-us-states-functions-class.php');

class Torque_US_States_CPT {

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
			'singular'       => 'State',
			'plural'         => 'States',
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
					'options'	=> $this->get_state_options()
				),
			),
			'state_code'
		);
	}

	private function get_state_options() {
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
}

?>
