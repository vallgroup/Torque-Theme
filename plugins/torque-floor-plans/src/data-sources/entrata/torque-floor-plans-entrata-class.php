<?php

class Torque_Floor_Plans_Entrata {

	public static $instance = NULL;

	public static function get_inst() {
		!self::$instance AND self::$instance = new self;

		return self::$instance;
	}

	/**
	 * left empty on purpose
	 */
	public function __construct() {}

}

?>
