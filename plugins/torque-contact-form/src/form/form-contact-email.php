<?php

// allow html content
function tq_careers_form_set_html_content_type() {
  return 'text/html';
}
add_filter( 'wp_mail_content_type', 'tq_careers_form_set_html_content_type');


ob_start();
?>

<h1>New Message</h1>
<p>Name: <?php echo $_POST['tq-name']; ?></p>
<p>Email: <?php echo $_POST['tq-email']; ?></p>
<p>Company: <?php echo $_POST['tq-company']; ?></p>
<p>Current State: <?php echo $_POST['tq-state']; ?></p>
<p>Current Zip: <?php echo $_POST['tq-zip']; ?></p>
<p>Phone: <?php echo $_POST['tq-phone']; ?></p>
<p>Message: <?php echo $_POST['tq-message']; ?></p>

<?php
$message = ob_get_clean();
$recipient = get_field('contact_page_form_recipient', 'option');
$subject = 'New Message';
$headers = array('Content-Type: text/html; charset=UTF-8');

// send mail
wp_mail( $recipient, $subject, $message, $headers );

// remove html filter to avoid conflicts
remove_filter( 'wp_mail_content_type', 'tq_careers_form_set_html_content_type');

?>
