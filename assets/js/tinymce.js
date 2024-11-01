var sunday_news_toolkit_element;

tinymce.PluginManager.add('sunday_news_toolkit_button', function(editor) {
  editor.addButton('sunday_news_toolkit_button', {
    title: sunday_news_toolkit_variables.translate.sunday_news_toolkit_elements,
    image: sunday_news_toolkit_variables.resource.icon,
    onclick: function(event) {
      var $box;
      event.preventDefault();
      $box = jQuery('#sunday-news-toolkit-elements');
      if ($box.length) {
        jQuery.featherlight($box, {
          closeOnClick: false
        });
      }
    }
  });
});

jQuery(window).load(function() {
  sunday_news_toolkit_element.toggle();
});

sunday_news_toolkit_element = {
  insert: function(button) {
    var code;
    code = button.next().html();
    tinymce.execCommand('mceInsertContent', false, code);
    jQuery.featherlight.current().close();
  },
  toggle: function() {
    jQuery('body').on('click', '.sunday-news-toolkit-title', function(event) {
      var content;
      content = jQuery(this).next();
      if (content.is(':hidden')) {
        content.slideDown();
        jQuery(this).find('.sunday-news-toolkit-caret').text('-');
      } else {
        content.slideUp();
        jQuery(this).find('.sunday-news-toolkit-caret').text('+');
      }
    });
  }
};

