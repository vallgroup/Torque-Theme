(function($) {
  $(document).ready(function() {
    // holds our row shortcode name
    var shortcode_string = "torque_slideshow";

    wp.media = wp.media || {};
    wp.mce = wp.mce || {};

    // our torque_slideshow template
    wp.mce.torque_slideshow = {
      // holds data from our shortcode
      shortcode_data: {},

      // set our template
      // @see editor-torque-slideshow-template.html
      template: wp.media.template("editor-torque-slideshow-template"),

      // gets called everytime the shortcode is
      // loaded in the Visual tab of the WYSISWYG
      getContent: function() {
        // build options
        var options = { ...this.shortcode.attrs.named };
        // insert template into editor
        return this.template(options);
      },

      // get called when clicking on the edit
      // button on the shortcode's UI in the
      // Visual tab of the WYSIWYG editor
      edit: function(data) {
        // build options
        var shortcode_data = wp.shortcode.next(shortcode_string, data);
        var values = shortcode_data.shortcode.attrs.named;
        wp.mce.torque_slideshow.popupwindow(tinyMCE.activeEditor, values);
      },

      popupwindow: function(editor, values, onsubmit_callback) {
        values = values || [];
        if (typeof onsubmit_callback !== "function") {
          onsubmit_callback = function(e) {
            // Insert content when the window form is submitted (this also replaces during edit, handy!)
            var _attr = {};

            if (e.data.id) {
              _attr.id = e.data.id;
            }

            var args = {
              tag: shortcode_string,
              type: "closed",
              content: "",
              attrs: _attr
            };
            editor.insertContent(wp.shortcode.string(args));
          };
        }
        var formBody = [
          {
            type: "textbox",
            name: "id",
            label: "Slideshow ID",
            value: values.id
          }
        ];

        editor.windowManager.open({
          title: "Torque Slideshow",
          body: formBody,
          onsubmit: onsubmit_callback
        });
      }
    }; // torque_slideshow

    // register the tinymce view template
    wp.mce.views.register(shortcode_string, wp.mce.torque_slideshow);
  });

  tinymce.PluginManager.add("torque_slideshow", function(editor) {
    editor.addButton("torque_slideshow_button", {
      text: "Torque Slideshow",
      icon: false,
      onclick: function() {
        wp.mce.torque_slideshow.popupwindow(editor);
      }
    });
  });
})(jQuery);
