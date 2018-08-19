;(function($) {
  $(document).ready(function() {
    // holds our row shortcode name
    var shortcode_string = '<torque_plugin_shortcode>'

    wp.media = wp.media || {}
    wp.mce = wp.mce || {}

    // our <torque_plugin_shortcode> template
    wp.mce.<torque_plugin_shortcode> = {
      // holds data from our shortcode
      shortcode_data: {},

      // set our template
      // @see editor-<torque_plugin_slug>-template.html
      template: wp.media.template('editor-<torque_plugin_slug>-template'),

      // gets called everytime the shortcode is
      // loaded in the Visual tab of the WYSISWYG
      getContent: function() {
        // build options
        var options = { ...this.shortcode.attrs.named }
        // insert template into editor
        return this.template(options)
      },

      // get called when clicking on the edit
      // button on the shortcode's UI in the
      // Visual tab of the WYSIWYG editor
      edit: function(data) {
        // build options
        var shortcode_data = wp.shortcode.next(shortcode_string, data)
        var values = shortcode_data.shortcode.attrs.named
        wp.mce.<torque_plugin_shortcode>.popupwindow(tinyMCE.activeEditor, values)
      },

      popupwindow: function(editor, values, onsubmit_callback) {
        values = values || []
        if (typeof onsubmit_callback !== 'function') {
          onsubmit_callback = function(e) {
            // Insert content when the window form is submitted (this also replaces during edit, handy!)
            var _attr = {}

            /*
            if (e.data.id) {
              _attr.id = e.data.id
            }
            if (e.data.title) {
              _attr.title = e.data.title
            }
            */

            var args = {
              tag: shortcode_string,
              type: 'closed',
              content: '',
              attrs: _attr,
            }
            editor.insertContent(wp.shortcode.string(args))
          }
        }
        var formBody = [
          /*
          {
            type: 'textbox',
            name: 'map_id',
            label: 'Map ID',
            value: values.map_id,
          },
          {
            type: 'textbox',
            name: 'title',
            label: 'Title',
            value: values.title,
          },
          */
        ]

        editor.windowManager.open({
          title: '<torque_plugin_name>',
          body: formBody,
          onsubmit: onsubmit_callback,
        })
      },
    } // <torque_plugin_shortcode>

    // register the tinymce view template
    wp.mce.views.register(shortcode_string, wp.mce.<torque_plugin_shortcode>)
  })

  tinymce.PluginManager.add('<torque_plugin_shortcode>', function(editor) {
    editor.addButton('<torque_plugin_shortcode>_button', {
      text: '<torque_plugin_name>',
      icon: false,
      onclick: function() {
        wp.mce.<torque_plugin_shortcode>.popupwindow(editor)
      },
    })
  })
})(jQuery)
