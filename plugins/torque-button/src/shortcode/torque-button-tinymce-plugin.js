;(function($) {
  $(document).ready(function() {
    // holds our row shortcode name
    var shortcode_string = 'torque_button'

    wp.media = wp.media || {}
    wp.mce = wp.mce || {}

    // our torque_button template
    wp.mce.torque_button = {
      // holds data from our shortcode
      shortcode_data: {},

      // set our template
      // @see editor-torque-button-template.html
      template: wp.media.template('editor-torque-button-template'),

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
        wp.mce.torque_button.popupwindow(tinyMCE.activeEditor, values)
      },

      popupwindow: function(editor, values, onsubmit_callback) {
        values = values || []
        if (typeof onsubmit_callback !== 'function') {
          onsubmit_callback = function(e) {
            // Insert content when the window form is submitted (this also replaces during edit, handy!)
            var _attr = {}

            if (e.data.text) {
              _attr.text = e.data.text
            }
            if (e.data.link) {
              _attr.link = e.data.link
            }
            if (e.data.new_tab) {
              _attr.new_tab = e.data.new_tab
            }
            if (e.data.is_download) {
              _attr.is_download = e.data.is_download
            }

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
          {
            type: 'textbox',
            name: 'text',
            label: 'Button Text',
            value: values.text,
          },
          {
            type: 'textbox',
            name: 'link',
            label:
              'Button Link (for a download, upload to media gallery then copy url here)',
            value: values.link,
          },
          {
            type: 'checkbox',
            name: 'new_tab',
            text: 'Open in New Tab?',
            checked: values.new_tab,
          },
          {
            type: 'checkbox',
            name: 'is_download',
            text: 'Treat as a Download?',
            checked: values.is_download,
          },
        ]

        editor.windowManager.open({
          title: 'Torque Button',
          body: formBody,
          onsubmit: onsubmit_callback,
        })
      },
    } // torque_button

    // register the tinymce view template
    wp.mce.views.register(shortcode_string, wp.mce.torque_button)
  })

  tinymce.PluginManager.add('torque_button', function(editor) {
    editor.addButton('torque_button_button', {
      text: 'Torque Button',
      icon: false,
      onclick: function() {
        wp.mce.torque_button.popupwindow(editor)
      },
    })
  })
})(jQuery)
