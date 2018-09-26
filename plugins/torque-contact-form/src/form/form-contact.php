<?php

require_once( Torque_Contact_Form_PATH . '/form/form-contact-template.php' );
require_once( Torque_Contact_Form_PATH . '/form/form-contact-field.php' );

class Torque_Contact_Form_Form {

  public static $FIELDS_FILTER_HANDLE = 'torque_contact_form_fields_filter';

  public static $NONCE_NAME = 'torque_contact_form_nonce';

  public static $HIDDEN_FIELD_NAME = 'torque_contact_form_hidden_field';

  private $fields = array();

  private $recipient;

  public function __construct( $recipient ) {
    $this->recipient = $recipient;

    // allow child theme to hide (or add) fields
    $this->fields = apply_filters( self::$FIELDS_FILTER_HANDLE, array(
      'Name'       => 'text',
      'Email'      => 'email',
      'Company'    => 'text',
      'State'      => 'text',
      'Zip Code'   => 'text',
      'Phone'      => 'tel',
      'Message'    => 'textarea'
    ));
  }

  public function get_form_markup() {
    $message = $this->maybe_handle_submit();

    $template = new Torque_Contact_Form_Form_Template( $this->fields, $message );
    return $template->create_markup();
  }

  public function maybe_handle_submit() {
    $message = null;

    if (isset($_POST[self::$HIDDEN_FIELD_NAME])) {
      // form was submitted
      try {
        foreach ($this->fields as $field) {
          if ( ! isset($_POST[$field]) ) {
            throw new Exception('All form fields are required');
          }
        }

        if (
          ! isset($_POST['_wpnonce']) ||
          ! wp_verify_nonce( $_POST['_wpnonce'], self::$NONCE_NAME )
        ) {
          // couldnt verify nonce
          throw new Exception('Form failed validation');
        }

        // form is validated - send email
        include locate_template( 'parts/forms/form-contact-email.php', false, false );

        $message = array(
          'success' => true,
          'message' => 'Message sent successfully!'
        );

      } catch (Exception $e) {

        $message = array(
          'success' => false,
          'message' => $e->getMessage() !== '' ? $e->getMessage() : 'Something went wrong'
        );
      }
    }

    return $message;
  }
}

?>
