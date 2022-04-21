var userface = document.getElementById("block-userfacemenu");

(function ($, Drupal) {
  Drupal.behaviors.instagram = {
    attach: function (context, settings) {
      $(context)
        .find(".circle")
        .on("click", function () {
          $("#block-userfacemenu").toggleClass("show");
        });
    },
  };
})(jQuery, Drupal);

(function ($, Drupal) {
  Drupal.behaviors.visual = {
    attach: function (context, settings) {
      $(context)
        .find("#edit-keys")
        .on("click keypress", function () {
          $(".fa-search").hide();
          $("#edit-keys").addClass("expand");
          $("#edit-keys").removeClass("shrink");
        });
      $("#edit-keys").keyup(function () {
        if ($("#edit-keys").val().length == 0) {
          $(".fa-search").show();
          $("#edit-keys").removeClass("expand");
          $("#edit-keys").addClass("shrink");
        }
      });
    },
  };
})(jQuery, Drupal);
var initial = window.location.href;
var count = initial.split("=")[1];

(function ($, Drupal) {
  Drupal.behaviors.instant = {
    attach: function (context, settings) {
      $('.each-row.slick-slide[data-slick-index= 0 ]').removeClass('slick-current');
      $('.each-row.slick-cloned:last-child').hide();
      $('.each-row.slick-slide[data-slick-index=' + count + ']').addClass('slick-current');
      $(context).find('.storiess').slick({
        
        initialSlide: count,
        centerMode: true,
        centerPadding: '0px 20px',
        slidesToShow: 5,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 5
            }
          },
          {
            breakpoint: 480,
            settings: {
              arrows: false,
              centerMode: true,
              centerPadding: '40px',
              slidesToShow: 1
            }
          }
        ]
      });
    },
  };
})(jQuery, Drupal);

