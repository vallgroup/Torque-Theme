<?php

class Print_Media_Templates_Hook {

  public function __construct() {
    add_action('print_media_templates', array( $this, 'print_media_templates_handler' ) );
  }

  public function print_media_templates_handler() {
    // define your backbone template;
    // the "tmpl-" prefix is required,
    // and your input field should have a data-setting attribute
    // matching the shortcode name
    ?>
    <script type="text/html" id="tmpl-gallery-layout-setting">
    <label class="setting">
      <span>Torque Gallery Layout</span>
      <select data-setting="torque_layout">
        <option value="6|4">6|4</option>
        <option value="4|6">4|6</option>
        <option value="1">1 (Full Width)</option>
        <option value="0">No Custom Layout</option>
      </select>
    </label>
    </script>

    <script>

    jQuery(document).ready(function(){

      // add your shortcode attribute and its default value to the
      // gallery settings list; $.extend should work as well...
      _.extend(wp.media.gallery.defaults, {
        torque_layout: '0'
      });

      // merge default gallery settings template with yours
      wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
        template: function(view){
          return wp.media.template('gallery-settings')(view)
               + wp.media.template('gallery-layout-setting')(view);
        }
      });

    });

    </script>

    <?php
  }
}

?>
