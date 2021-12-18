(function($, Drupal) {
    Drupal.behaviors.visual = {
        attach: function(context, settings) {
            $('.user-menu-avatar.circle', context).click(function() {

                document.getElementById("block-userfacemenu").classList.toggle('show');
            });
        }
    }
})(jQuery, Drupal);