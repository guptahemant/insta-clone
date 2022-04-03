(function($, Drupal) {
    Drupal.behaviors.visual = {
        attach: function(context, settings) {
            $(context).find('a.cancel').on('click', function() {
                document.querySelector('button.ui-dialog-titlebar-close').click();
            });
        }
    }
})(jQuery, Drupal);

