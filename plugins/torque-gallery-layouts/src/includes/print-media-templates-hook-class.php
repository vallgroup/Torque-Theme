<?php

/**
 * This class handles the modifications we make to the WP gallery shortcode settings form.
 *
 * At the moment, we hide wordpress's default settings from the form,
 * but since the shortcode will still expect them as attributes and fill in the defaults
 * we can still include them in our logic and set them to whatever we want
 * without having to worry about the user changing them.
 *
 */
class Print_Media_Templates_Hook {

  public static $data_setting_slug = 'torque_layout';

  /**
   * Set up the gallery atts defaults,
   * adding our own custom setting and its' default at the end
   *
   * Setting the wordpress default gallery atts here will override them.
   * If the wordpress default form is hidden, then these are the ones that will be used
   * in the output
   */
  public static function get_gallery_defaults() {
    $gallery_defaults = array(
      'link'                    => 'none',
      'size'                    => 'full',
      'columns'                 => '2'
    );
    $gallery_defaults[self::$data_setting_slug] = '0';

    return $gallery_defaults;
  }

  /**
   * Register the action
   */
  public function __construct() {
    add_action('print_media_templates', array( $this, 'print_media_templates_handler' ) );
  }

  /**
   * To edit the form, we have to run a script on the hook
   * which will define our new settings template and replace/append to the old one
   */
  public function print_media_templates_handler() {

    // define backbone template;
    // the "tmpl-" prefix is required,
    // and the input field should have a data-setting attribute
    // matching the shortcode name
    $gallery_defaults = self::get_gallery_defaults();

    ?>
    <script type="text/html" id="tmpl-gallery-layout-setting">
    <h2 style="display: inline-block;">Torque Custom Settings</h2>
    <label class="setting">
      <span>Torque Gallery Layout</span>
      <select data-setting="<?php echo self::$data_setting_slug; ?>">
        <option value="0">No Custom Layout</option>
        <option value="6|4">6|4</option>
        <option value="4|6">4|6</option>
        <option value="10">10 (Full Width)</option>
      </select>
    </label>
    </script>

    <script>

    jQuery(document).ready(function(){

      // add shortcode attribute and its default value to the
      // gallery settings list;
      //
      // we set some other default values here for the default wordpress gallery atts
      $.extend(wp.media.gallery.defaults, {
        torque_layout: '<?php echo $gallery_defaults[self::$data_setting_slug]; ?>',
        link: '<?php echo $gallery_defaults['link']; ?>',
        size: '<?php echo $gallery_defaults['size']; ?>',
        columns: '<?php echo $gallery_defaults['columns']; ?>'
      });

      // merge default gallery settings template with yours
      wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
        template: function(view){
          /*
          if you want to get back the default wordpress settings, use this return

          return wp.media.template('gallery-settings')(view)
               + wp.media.template('gallery-layout-setting')(view);
           */

          // return our own settings in place of wordpress default
          return wp.media.template('gallery-layout-setting')(view);
        }
      });

    });

    </script>

    <?php
  }
}

?>
