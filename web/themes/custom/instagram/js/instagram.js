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


jQuery(document).ready(function(){
    jQuery(".js-form-item-name .js-form-required").text("Phone number,username or email address");
});

jQuery(document).on("input",".js-form-item .form-text", function () {
    jQuery(this).parent().children(".form-required").addClass("focused");
    if (
        jQuery("#edit-name").val().length >= 1 &&
        jQuery("#edit-pass").val().length >= 6
    ) {
        jQuery(".js-form-submit").addClass("active");
        jQuery(".js-form-submit").prop('disabled', false);
    } else {
        jQuery(".js-form-submit").removeClass("active");
        jQuery(".js-form-submit").prop('disabled', true);

    }
});


jQuery(document).on("input",".js-form-item .form-text", function () {
    jQuery(this).parent().children(".form-required").addClass("focused");
    if (
        jQuery("#edit-pass").val().length >= 1
    ) {
        jQuery(".pass-toggle").removeClass("show");
        
    } else {
        jQuery(".pass-toggle").addClass("show");
    }
});


jQuery(".pass-toggle").click(function () {
    if (jQuery("#edit-pass").attr("type") == "password") {
        
        jQuery("#edit-pass").attr("type", "text");
        jQuery(this).text('Hide');
    } else {
        jQuery("#edit-pass").attr("type", "password");
        jQuery(this).text('Show');
    }
});

document.querySelector("label.pass-toggle")