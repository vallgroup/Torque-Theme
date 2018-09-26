<?php

class Torque_Contact_Form_Field_Factory {

  public static $supported_field_types = array(
    'text',
    'textarea',
    'email',
    'tel'
  );

  public static function create_new( $type, $name ) {
    switch( $type ) {

      case 'text':
        return self::create_text_field($name);

      case 'textarea':
        return self::create_textarea_field($name);

      case 'email':
        return self::create_email_field($name);

      case 'tel':
        return self::create_tel_field($name);
    }
  }

  private static function create_text_field($name) {
    $id = self::create_field_id($name);

    ob_start();
    ?>
    <input type="text" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
    <?php

    $content = ob_get_clean();

    return self::wrap_field($name, $content);
  }

  private static function create_textarea_field($name) {
    $id = self::create_field_id($name);

    ob_start();
    ?>
    <textarea name="<?php echo $id; ?>" id="<?php echo $id; ?>" ></textarea>
    <?php

    $content = ob_get_clean();

    return self::wrap_field($name, $content);
  }

  private static function create_email_field($name) {
    $id = self::create_field_id($name);

    ob_start();
    ?>
    <input type="email" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
    <?php

    $content = ob_get_clean();

    return self::wrap_field($name, $content);
  }

  private static function create_tel_field($name) {
    $id = self::create_field_id($name);

    ob_start();
    ?>
    <input type="tel" name="<?php echo $id; ?>" id="<?php echo $id; ?>" />
    <?php

    $content = ob_get_clean();

    return self::wrap_field($name, $content);
  }

  private static function wrap_field($name, $content) {
    ob_start();

    $id = self::create_field_id($name);
    ?>

    <div class="input-wrapper">
      <label for="<?php echo self::create_field_id($name); ?>"><?php echo $name; ?></label>
      <?php echo $content; ?>
    </div>

    <?php
    return ob_get_clean();
  }

  public static function create_field_id($name) {
    return 'tq-'.str_replace(' ', '-', strtolower($name) );
  }
}

?>
