<?php

require( plugin_dir_path(__FILE__) . 'entrata/torque-floor-plans-entrata-class.php' );
require( Torque_Floor_Plans_PATH . '/custom-post-types/torque-floor-plan-cpt-class.php' );
require( Torque_Floor_Plans_PATH . '/api/torque-floor-plans-rest-controller-class.php' );

class Torque_Floor_Plans_Data_Source {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}
	
	public function __construct() {}



	public static $DATA_SOURCE_FILTER_SLUG = 'torque_floor_plans_data_source';

	public static $SUPPORTED_DATA_SOURCES = [ false, 'entrata' ];


	public $DATA_SOURCE = false;


	public function init() {
		$this->set_data_source();

		switch ( $this->DATA_SOURCE ) {

			case 'entrata':
				Torque_Floor_Plans_Entrata::get_inst()->init();
				break;

			default:
				new Torque_Floor_Plan_CPT();
				new Torque_Floor_Plans_REST_Controller();
		}
	}

	public function get_shortcode_markup() {
		$extra_markup = 'data-source="'.$this->DATA_SOURCE.'"';

		switch ( $this->DATA_SOURCE ) {

			case 'entrata':
				$extra_markup .= Torque_Floor_Plans_Entrata::get_inst()->get_shortcode_markup();
				break;

			// default has no extra props
		}

		return $extra_markup;
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
