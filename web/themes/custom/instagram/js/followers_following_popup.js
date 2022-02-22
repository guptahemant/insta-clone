(function($, Drupal) {
  Drupal.behaviors.followers_following_popup = {
    attach: function(context, settings) {
      $(context).find('.following').on('click', function(e) {
        $(e.target).next( ".following_link_pop" ).css({'display':'flex'});
      });

      $(context).find('.cancel').on('click', function(e) {
        $(e.target).closest( ".following_link_pop" ).css({'display':'none'});
      });

      $(context).find('.use-ajax').on('click', function(e) {
        $(e.target).closest( ".following_link_pop" ).css({'display':'none'});
      });
    }
  }
})(jQuery, Drupal);
