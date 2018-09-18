(function($) {
  $(document).ready(function() {
    /*
      Fetch data needed for the form
     */

    const origin = window.location.origin;

    let postTypeOptions = [];
    let linkSourceOptions = [];
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
          postTypes = data.options.post_types;
          postTypeOptions = Object.keys(postTypes).map(postType => {
            return { text: postTypes[postType], value: postType };
          });

          linkSources = data.options.link_source_options;
          linkSourceOptions = Object.keys(linkSources).map(linkSource => {
            return {
              text: `Metabox - ${linkSources[linkSource]}`,
              value: linkSource
            };
          });
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
        values = values || [];

        if (typeof onsubmit_callback !== "function") {
          onsubmit_callback = function(e) {
            // Insert content when the window form is submitted (this also replaces during edit, handy!)
            var _attr = {};

            if (e.data.post_type) {
              _attr.post_type = e.data.post_type;
            }

            if (e.data.instructional_text) {
              _attr.instructional_text = e.data.instructional_text;
            }

            if (e.data.link_text) {
              _attr.link_text = e.data.link_text;
            }

            if (e.data.link_source) {
              _attr.link_source = e.data.link_source;
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
            type: "listbox",
            name: "post_type",
            label: "Post Type",
            values: postTypeOptions
          },
          {
            type: "textbox",
            name: "instructional_text",
            label: "App Instructional Text",
            value: values.instructional_text,
            placeholder: "Click on a state to filter posts below"
          },
          {
            type: "textbox",
            name: "link_text",
            label: "Loop CTA Text",
            value: values.link_text,
            placeholder: "View"
          },
          {
            type: "listbox",
            name: "link_source",
            label: "Loop CTA Link Source",
            values: [
              { text: "Default Permalink", value: "permalink" },
              ...linkSourceOptions
            ]
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
