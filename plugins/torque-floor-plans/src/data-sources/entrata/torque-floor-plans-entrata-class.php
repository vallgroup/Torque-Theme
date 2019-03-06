<?php

require_once( plugin_dir_path(__FILE__) . 'entrata-api-class.php' );

class Torque_Floor_Plans_Entrata {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	public function __construct() {}


  public static $PROPERTY_ID_FILTER_SLUG = 'torque_floor_plans_entrata_property_id';

  public $PROPERTY_ID = false;

  public function init() {
    $this->PROPERTY_ID = apply_filters(self::$PROPERTY_ID_FILTER_SLUG, $this->PROPERTY_ID);

		Entrata_API::get_inst()->init($this->PROPERTY_ID);
	}

  public function get_shortcode_markup() {
    return '';
  }
}

?>
