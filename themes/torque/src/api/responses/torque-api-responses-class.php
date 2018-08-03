<?php

/**
 * This class defines functions which should be used for __ALL__ REST API
 * controller responses across all plugins and themes.
 *
 * It's important that we can expect certain things from any response we get
 * from any custom API endpoints, and normalise the response shape to a degree.
 */

class Torque_API_Responses {

  static public function Success_Response( $data = null ) {
    $response = array(
      'success' => true
    );

    if ( $data && ! empty($data) ) {
      $response = array_merge( $response, $data );
    }

    return rest_ensure_response( $response );
  }

  static public function Failure_Response( $data = null ) {
    $response = array(
      'success' => false
    );

    if ( $data && ! empty($data) ) {
      $response = array_merge( $response, $data );
    }

    return rest_ensure_response( $response );
  }

  static public function Error_Response( $error ) {
    if ($error instanceof WP_Error) {
      return rest_ensure_response( $error );

    } else {
      $code = $error->getCode();
      $code = $code && $code !== 0 ? $code : 500;

      $message = $error->getMessage();
      $message = $message && $message !== '' ? $message : 'API Error';

      return new WP_Error($code, $message);
    }
  }
}

?>
