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
  Drupal.behaviors.instant = {
    attach: function (context, settings) {
      $(context).find('.storiess').slick({
        centerMode: true,
        centerPadding: '120px',
        slidesToShow: 4,
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

