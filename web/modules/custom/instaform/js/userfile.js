(function($, Drupal) {
    Drupal.behaviors.visual = {
        attach: function(context, settings) {
            
            $('.js-form-item-imagefile').change(function(){
	            document.querySelector('.submitimage').click();
	        });
            
        }
    }
})(jQuery, Drupal);
