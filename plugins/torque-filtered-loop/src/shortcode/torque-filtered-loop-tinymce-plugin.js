(function($) {
  $(document).ready(function() {
    // holds our row shortcode name
    var shortcode_string = "torque_filtered_loop";

    wp.media = wp.media || {};
    wp.mce = wp.mce || {};

    // our torque_filtered_loop template
    wp.mce.torque_filtered_loop = {
      // holds data from our shortcode
      shortcode_data: {},

      // set our template
      // @see editor-torque-filtered-loop-template.html
      template: wp.media.template("editor-torque-filtered-loop-template"),

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
        wp.mce.torque_filtered_loop.popupwindow(tinyMCE.activeEditor, values);
      },

      popupwindow: function(editor, values, onsubmit_callback) {
        values = values || [];
        if (typeof onsubmit_callback !== "function") {
          onsubmit_callback = function(e) {
            // Insert content when the window form is submitted (this also replaces during edit, handy!)
            var _attr = {};

            if (e.data.tax) {
              _attr.tax = e.data.tax;
            }

            if (e.data.parent) {
              _attr.parent = e.data.parent;
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
            name: "tax",
            label: "Taxonomy For Filter",
            value: values.tax
          },
          {
            type: "textbox",
            name: "parent",
            label: "Parent Term (optional)",
            value: values.parent
          }
        ];

        editor.windowManager.open({
          title: "Torque Filtered Loop",
          body: formBody,
          onsubmit: onsubmit_callback
        });
      }
    }; // torque_filtered_loop

    // register the tinymce view template
    wp.mce.views.register(shortcode_string, wp.mce.torque_filtered_loop);
  });

  tinymce.PluginManager.add("torque_filtered_loop", function(editor) {
    editor.addButton("torque_filtered_loop_button", {
      text: "Torque Filtered Loop",
      icon: false,
      onclick: function() {
        wp.mce.torque_filtered_loop.popupwindow(editor);
      }
    });
  });
})(jQuery);
