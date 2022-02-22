var x = window.matchMedia("(max-width: 425px)");
(function($, Drupal) {
  Drupal.behaviors.user_profile_wrapper = {
    attach: function(context, settings) 
    {
      if (x.matches)
      {
        $('article, .wrapright').once('user_profile_wrapper').each(function () {
          $('article, .wrapright').wrapAll('<div class="wrapper" />');
          $('.uname, .flag-following, .settings').wrapAll('<div class="wraptop" />');
          $('.bottom, .wrapcount').wrapAll('<div class="bottomwrap" />');
        });
      }else{
        $('article, .wrapright').once('user_profile_wrapper').each(function () {
          $('article, .wrapright').wrapAll('<div class="wrapper" />');
        });
      }

      bool = true;
      $(context).find('.suggestion').on('click', function(){
        if (bool == true) {
          $('.suggestion').addClass('suggestion-click2');
            $('#block-views-block-suggesstion-block-2--2').css({'display':'block'});
          bool = false;
        } else {
          $(' .suggestion').removeClass('suggestion-click2');
          $('#block-views-block-suggesstion-block-2--2').css({'display':'none'});
          bool = true;
        }
      });

      bool2 = false;
      $(context).find('.use-ajax').on('click', function(e){
        $(e.target).closest(' .slick__slide').css({'display':'none'});
      });
    }
  }
})(jQuery, Drupal);
