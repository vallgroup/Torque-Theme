(function($) {
  $(document).ready(function() {
    /*
      Fetch data needed for the form
     */

    const origin = window.location.origin;

    let postTypeOptions = [];
    fetch(origin + "/index.php/wp-json/us-states/v1/options").then(function(
      response
    ) {
      if (response.status !== 200) {
        console.warn(
          "Problem fetching US States options. Status Code: " + response.status
        );
        return;
      }

      // Examine the text in the response
      response.json().then(function(data) {
        if (data.success) {
          postTypeOptions = data.options.post_types;
        }
      });
    });

    /*
      End of fetches
     */

    // holds our row shortcode name
    var shortcode_string = "torque_us_states";

    wp.media = wp.media || {};
    wp.mce = wp.mce || {};

    // our torque_us_states template
    wp.mce.torque_us_states = {
      // holds data from our shortcode
      shortcode_data: {},

      // set our template
      // @see editor-torque-us-states-template.html
      template: wp.media.template("editor-torque-us-states-template"),

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
        wp.mce.torque_us_states.popupwindow(tinyMCE.activeEditor, values);
      },

      popupwindow: function(editor, values, onsubmit_callback) {
        console.log(postTypeOptions);
        values = values || [];
        if (typeof onsubmit_callback !== "function") {
          onsubmit_callback = function(e) {
            // Insert content when the window form is submitted (this also replaces during edit, handy!)
            var _attr = {};

            if (e.data.postType) {
              _attr.postType = e.data.postType;
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
            type: "selectbox",
            name: "postType",
            label: "Post Type",
            value: values.postType,
            options: Object.keys(postTypeOptions)
          }
        ];

        editor.windowManager.open({
          title: "Torque US States",
          body: formBody,
          onsubmit: onsubmit_callback
        });
      }
    }; // torque_us_states

    // register the tinymce view template
    wp.mce.views.register(shortcode_string, wp.mce.torque_us_states);
  });

  tinymce.PluginManager.add("torque_us_states", function(editor) {
    editor.addButton("torque_us_states_button", {
      text: "Torque US States",
      icon: false,
      onclick: function() {
        wp.mce.torque_us_states.popupwindow(editor);
      }
    });
  });
})(jQuery);
