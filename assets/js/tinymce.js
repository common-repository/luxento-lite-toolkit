var luxento_toolkit_Element;

tinymce.PluginManager.add('luxento_toolkit_button', function(editor) {
  editor.addButton('luxento_toolkit_button', {
    title: luxento_toolkit_variables.translate.luxento_toolkit_elements,
    image: luxento_toolkit_variables.resource.icon,
    onclick: function(event) {
      var $box;
      event.preventDefault();
      $box = jQuery('#luxento-toolkit-elements');
      if ($box.length) {
        jQuery.featherlight($box, {
          closeOnClick: false
        });
      }
    }
  });
});

jQuery(window).load(function() {
  luxento_toolkit_Element.toggle();
});

luxento_toolkit_Element = {
  insert: function(button) {
    var code;
    code = button.next().html();
    tinymce.execCommand('mceInsertContent', false, code);
    jQuery.featherlight.current().close();
  },
  toggle: function() {
    jQuery('body').on('click', '.luxento-toolkit-title', function(event) {
      var content;
      content = jQuery(this).next();
      if (content.is(':hidden')) {
        content.slideDown();
        jQuery(this).find('.luxento-toolkit-caret').text('-');
      } else {
        content.slideUp();
        jQuery(this).find('.luxento-toolkit-caret').text('+');
      }
    });
  }
};

