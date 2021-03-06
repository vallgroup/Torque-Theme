<?php

require_once( Torque_Contact_Form_PATH . '/form/form-contact-template.php' );
require_once( Torque_Contact_Form_PATH . '/form/form-contact-field.php' );
require_once( Torque_Contact_Form_PATH . '/form/form-contact-email.php' );

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
      'tq-name'               => array(
        'name'  => 'Name',
        'type'  => 'text'
      ),
      'tq-email'              => array(
        'name'  => 'Email',
        'type'  => 'email'
      ),
      'tq-state'              => array(
        'name'  => 'State',
        'type'  => 'text'
      ),
      'tq-zip'                => array(
        'name'  => 'Zip Code',
        'type'  => 'text'
      ),
      'tq-phone'              => array(
        'name'  => 'Phone',
        'type'  => 'tel'
      ),
      /*
       Example radio buttons option

      'tq-resident-investor'  => array(
        'name'    => 'I am a:',
        'type'    => 'radio',
        'options' => array(
          'resident'  => 'Resident',
          'investor'  => 'Investor'
        )
      ),
      */
      'tq-message'            => array(
        'name'  => 'Message',
        'type'  => 'textarea'
      ),
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
        foreach ($this->fields as $field_id => $field_options) {
          if ( ! isset( $_POST[$field_id] ) ) {
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
        $email = new Torque_Contact_Form_Email($this->recipient, $this->fields);
        $email->send();

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
