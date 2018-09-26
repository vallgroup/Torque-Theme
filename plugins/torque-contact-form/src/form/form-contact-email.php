<?php

class Torque_Contact_Form_Email {

  private $recipient = '';

  private $fields = array();

  public function __construct($recipient, $fields) {
    $this->recipient = $recipient;
    $this->fields = $fields;
  }

  public function send() {
    // allow html content
    add_filter( 'wp_mail_content_type', array($this, 'set_html_content_type'));

    $message = $this->create_message();
    $subject = 'New Message';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    // send mail
    var_dump($message);
    wp_mail( $this->recipient, $subject, $message, $headers );

    // remove html filter to avoid conflicts
    remove_filter( 'wp_mail_content_type', array($this, 'set_html_content_type'));
  }

  /**
   * We need this as a separate function so we can remove the filter too
   */
  public function set_html_content_type() {
    return 'text/html';
  }

  private function create_message() {
    ob_start();
    ?>

    <h1>New Message</h1>

    <?php
    foreach ($this->fields as $id => $options) {
    ?>
      <p><?php echo $options['name']; ?>: <?php echo $_POST[$id]; ?></p>
    <?php
    }

    return ob_get_clean();
  }
}

?>
