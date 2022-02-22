(function($, Drupal) {
    Drupal.behaviors.visual = {
        attach: function(context, settings) {
            $(context).find('.nextbutton').on('click', function() {
                document.querySelector("div.ui-front").classList.add('step2');
            });

            $(context).find('.submitbutton').on('click', function() {
                document.querySelector("div.ui-front").classList.remove('step2');
            });

            $(context).find('.access-title').on('click', function() {
                document.querySelector("div.accessibility").classList.add('show');
                document.querySelector("div.access-title").classList.add('hide');
            });

            $(context).find('.access1').on('click', function() {
                document.querySelector("div.accessibility").classList.remove('show');
                document.querySelector("div.access-title").classList.remove('hide');
            });

            $(context).find('span.choose').on('click', function() {
                document.querySelector('.js-form-type-managed-file input.form-file').click();
            });
            $('.form-file').change(function(){
	            document.querySelector('.nextbutton').click();
	        });	
           

        }
    }
})(jQuery, Drupal);

