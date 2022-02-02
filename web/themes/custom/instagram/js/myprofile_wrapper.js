var x = window.matchMedia("(max-width: 425px)");
(function($, Drupal) {
  Drupal.behaviors.user_profile_wrapper = {
    attach: function(context, settings) 
    {
      if (x.matches)
      {
        $('article, .wrapright').once('user_profile_wrapper').each(function () {
          $('article, .wrapright').wrapAll('<div class="wrapper" />');
          $('.uname, .settings').wrapAll('<div class="wraptop" />');
          $('.bottom, .wrapcount').wrapAll('<div class="bottomwrap" />');
        });
      }else{
        $('article, .wrapright').wrapAll('<div class="wrapper" />');
      }
    }
  }
})(jQuery, Drupal);
