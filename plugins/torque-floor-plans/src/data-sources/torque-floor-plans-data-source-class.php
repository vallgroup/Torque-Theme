<?php

class Torque_Floor_Plans_Data_Source {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	/**
	 * left empty on purpose
	 */
	public function __construct() {}



	public static $DATA_SOURCE_FILTER_SLUG = 'torque-floor-plans-data-source';

	public static $SUPPORTED_DATA_SOURCES = [ false, 'entrata' ];


	public $DATA_SOURCE = false;


	/**
   * This should be a function which registers all the plugin's required hooks.
   */
	public function init() {
		$this->set_data_source();

		switch ( $this->DATA_SOURCE ) {

			case 'entrata':
				require( plugin_dir_path(__FILE__) . 'entrata/torque-floor-plans-entrata-class.php' );
				new Torque_Floor_Plans_Entrata();
				break;

			default:
				require( Torque_Floor_Plans_PATH . '/custom-post-types/torque-floor-plan-cpt-class.php' );
				require( Torque_Floor_Plans_PATH . '/api/torque-floor-plans-rest-controller-class.php' );

				// register plugin specific CPTs
				new Torque_Floor_Plan_CPT();

				// init the REST Controller
				new Torque_Floor_Plans_REST_Controller();
		}
	}

	private function set_data_source() {
		$new_source = apply_filters(self::$DATA_SOURCE_FILTER_SLUG, $this->DATA_SOURCE);

		if ( in_array( $new_source, self::$SUPPORTED_DATA_SOURCES ) ) {
			$this->DATA_SOURCE = $new_source;
		} else {
			throw new Exception('Data source '.$new_source.' not supported by '.self::$PLUGIN_NAME);
		}
	}
}

?>
