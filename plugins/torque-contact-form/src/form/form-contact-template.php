<?php

require_once( Torque_Contact_Form_PATH . '/form/form-contact.php' );
require_once( Torque_Contact_Form_PATH . '/form/form-contact-field.php' );

class Torque_Contact_Form_Form_Template {

  private $fields = array();

  private $message;

  public function __construct( $fields, $message = NULL) {
    $this->fields = $fields;

    if ( $message ) {
      $this->message = $message;
    }
  }

  public function create_markup() {
    ob_start();
    ?>

    <div id="contact-form" class="torque-form">

      <?php $this->the_message(); ?>

      <form method="post" action="#contact-form" >

        <?php $this->the_nonce(); ?>

        <?php
        // this hidden input is important for us to know
        // if the form has been submitted yet
        // so we can check that all fields are filled
        ?>
        <input type="hidden" name="<?php echo Torque_Contact_Form_Form::$HIDDEN_FIELD_NAME; ?>" />

        <?php $this->the_fields(); ?>

        <button type="submit">Send</button>

      </form>

    </div>

    <?php
    return ob_get_clean();
  }

  private function the_message() {
    echo $this->get_the_message();
  }

  private function get_the_message() {
    ob_start();

    if (isset($this->message) && $this->message) {

      $success_class = ! $this->message['success'] ? 'error' : '';

      ?>

      <div class="form-message <?php echo $success_class; ?>">
        <?php echo $this->message['message']; ?>
      </div>

      <?php
    }

    return ob_get_clean();
  }

  private function the_nonce() {
    echo $this->get_the_nonce();
  }

  private function get_the_nonce() {
    return wp_nonce_field( Torque_Contact_Form_Form::$NONCE_NAME );
  }

  private function the_fields() {

    foreach ($this->fields as $name => $type) {

      if ( in_array( $type, Torque_Contact_Form_Field_Factory::$supported_field_types ) ) {

        echo Torque_Contact_Form_Field_Factory::create_new($type, $name);

      }
    }
  }
}

?>
