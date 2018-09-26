(function($) {
  $(document).ready(function() {
    // holds our row shortcode name
    var shortcode_string = "torque_contact_form";

    wp.media = wp.media || {};
    wp.mce = wp.mce || {};

    // our torque_contact_form template
    wp.mce.torque_contact_form = {
      // holds data from our shortcode
      shortcode_data: {},

      // set our template
      // @see editor-torque-contact-form-template.html
      template: wp.media.template("editor-torque-contact-form-template"),

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
        wp.mce.torque_contact_form.popupwindow(tinyMCE.activeEditor, values);
      },

      popupwindow: function(editor, values, onsubmit_callback) {
        values = values || [];
        if (typeof onsubmit_callback !== "function") {
          onsubmit_callback = function(e) {
            // Insert content when the window form is submitted (this also replaces during edit, handy!)
            var _attr = {};

            if (e.data.recipient_email) {
              _attr.recipient_email = e.data.recipient_email;
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
            name: "recipient_email",
            label: "Recipient Email (defaults to site admin email)",
            value: values.recipient_email
          }
        ];

        editor.windowManager.open({
          title: "Torque Contact Form",
          body: formBody,
          onsubmit: onsubmit_callback
        });
      }
    }; // torque_contact_form

    // register the tinymce view template
    wp.mce.views.register(shortcode_string, wp.mce.torque_contact_form);
  });

  tinymce.PluginManager.add("torque_contact_form", function(editor) {
    editor.addButton("torque_contact_form_button", {
      text: "Torque Contact Form",
      icon: false,
      onclick: function() {
        wp.mce.torque_contact_form.popupwindow(editor);
      }
    });
  });
})(jQuery);
