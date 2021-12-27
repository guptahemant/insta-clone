var userface = document.getElementById("block-userfacemenu");

(function($, Drupal) {
    Drupal.behaviors.visual = {
        attach: function(context, settings) {
            $(context).find('.circle').on('click', function() {
                document.getElementById("block-userfacemenu").classList.toggle('show');
            });
        }
    }
})(jQuery, Drupal);