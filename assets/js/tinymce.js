var nictiz_toolkit_element;

tinymce.PluginManager.add('nictiz_toolkit_button', function(editor) {
  editor.addButton('nictiz_toolkit_button', {
    title: nictiz_toolkit_variables.translate.nictiz_toolkit_elements,
    image: nictiz_toolkit_variables.resource.icon,
    onclick: function(event) {
      var $box;
      event.preventDefault();
      $box = jQuery('#nictiz-toolkit-elements');
      if ($box.length) {
        jQuery.featherlight($box, {
          closeOnClick: false
        });
      }
    }
  });
});

jQuery(window).load(function() {
  nictiz_toolkit_element.toggle();
});

nictiz_toolkit_element = {
  insert: function(button) {
    var code;
    code = button.next().html();
    tinymce.execCommand('mceInsertContent', false, code);
    jQuery.featherlight.current().close();
  },
  toggle: function() {
    jQuery('body').on('click', '.nictiz-toolkit-title', function(event) {
      var content;
      content = jQuery(this).next();
      if (content.is(':hidden')) {
        content.slideDown();
        jQuery(this).find('.nictiz-toolkit-caret').text('-');
      } else {
        content.slideUp();
        jQuery(this).find('.nictiz-toolkit-caret').text('+');
      }
    });
  }
};

