<?php global $post_id, $email_templates, $document; ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo esc_html( $document->post_title ); ?></title>
  </head>
  <body>
    <pre><?php var_dump( $document ) ?></pre>
    <pre><?php var_dump( $email_templates ) ?></pre>
  </body>
</html>
