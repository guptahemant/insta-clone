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

