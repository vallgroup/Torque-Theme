<?php

/**
 * Holds permissions callback functions which can be used by any REST API
 * route definitions.
 */

class Torque_API_Permissions {

  public static function user_can_edit( $request, $id ) {
  	if ( ! current_user_can( 'edit_post', $id ) ) {
  		return new WP_Error(
        'rest_forbidden',
        esc_html__( 'You cannot edit this resource.' ),
        array( 'status' => self::get_authorization_status_code() )
      );
  	}
  	return true;
  }

  public static function user_can_read( $request ) {
  	if ( ! current_user_can( 'read' ) ) {
  		return new WP_Error(
        'rest_forbidden',
        esc_html__( 'You cannot view this resource.' ),
        array( 'status' => self::get_authorization_status_code() )
      );
  	}
  	return true;
  }

  public static function user_can_create( $request ) {
  	if ( ! current_user_can( 'edit_posts' ) ) {
  		return new WP_Error(
        'rest_forbidden',
        esc_html__( 'You cannot edit this resource.' ),
        array( 'status' => self::get_authorization_status_code() )
      );
  	}
  	return true;
  }

  // Sets up the proper HTTP status code for authorization.
  private static function get_authorization_status_code() {
      $status = 401;

      if ( is_user_logged_in() ) {
          $status = 403;
      }

      return $status;
  }
}

?>
