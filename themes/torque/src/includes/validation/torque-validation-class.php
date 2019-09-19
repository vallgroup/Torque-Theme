<?php

/**
* Validate params across multiple resources and endpoints
*/
class Torque_Validation {

	function __construct(){}

	/**
	 * Make sure that the param beign passed is a int
	 *
	 * @param  mixed   $param   the param to check
	 * @param  object  $request the WP Request
	 * @return boolean
	 */
	public static function int( $param, $request, $key ) {
    return is_numeric( $param );
  }

  /**
   * Make sure that the param beign passed is a string
   *
   * @param  mixed   $param   the param to check
   * @param  object  $request the WP Request
   * @return boolean
   */
  public static function string( $param, $request, $key ) {
    return is_string( $param );
  }

  /**
   * Make sure that the param beign passed is a array
   *
   * @param  mixed   $param   the param to check
   * @param  object  $request the WP Request
   * @return boolean
   */
  public static function arr( $param, $request, $key ) {
    return is_array( $param );
  }

  /**
   * Make sure params being passed is a boolean value
   *
   * @param  mixed  $param   the value to check
   * @param  object $request the resuqest
   * @return boolean
   */
  public static function bool( $param, $request, $key ) {
		if (is_bool( $param )) {
			return true;
		}

    if ( is_numeric( $param ) && '0' == $param || '1' == $param) {
      return true;
    }

    if ( is_string( $param ) && 'false' == strtolower( trim( $param ) ) || 'true' == strtolower( trim( $param) ) ) {
      return true;
    }

    return false;
  }
}
