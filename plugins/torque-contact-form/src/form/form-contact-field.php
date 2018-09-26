<?php

class Torque_Contact_Form_Field_Factory {

  public static $supported_field_types = array(
    'text',
    'textarea',
    'email',
    'tel'
  );

  public static function create_new( $id, $options ) {
    $type = $options['type'] ?? false;

    if ( ! $type ) {
      return;
    }

    switch( $type ) {

      case 'text':
        return self::create_text_field($id, $options);

      case 'textarea':
        return self::create_textarea_field($id, $options);

      case 'email':
        return self::create_email_field($id, $options);

      case 'tel':
        return self::create_tel_field($id, $options);
    }
  }

  private static function create_text_field($id, $options) {
    ob_start();
    ?>
    <input type="text" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
    <?php

    $content = ob_get_clean();

    return self::wrap_field($id, $options, $content);
  }

  private static function create_textarea_field($id, $options) {
    ob_start();
    ?>
    <textarea name="<?php echo $id; ?>" id="<?php echo $id; ?>" ></textarea>
    <?php

    $content = ob_get_clean();

    return self::wrap_field($id, $options, $content);
  }

  private static function create_email_field($id, $options) {
    ob_start();
    ?>
    <input type="email" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
    <?php

    $content = ob_get_clean();

    return self::wrap_field($id, $options, $content);
  }

  private static function create_tel_field($id, $options) {
    ob_start();
    ?>
    <input type="tel" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
    <?php

    $content = ob_get_clean();

    return self::wrap_field($id, $options, $content);
  }

  private static function wrap_field($id, $options, $content) {
    ob_start();

    $name = $options['name'] ?? '';
    
    ?>

    <div class="input-wrapper">
      <label for="<?php echo $id; ?>"><?php echo $name; ?></label>
      <?php echo $content; ?>
    </div>

    <?php
    return ob_get_clean();
  }
}

?>
