(function ($, Drupal) {
  Drupal.behaviors.postlike = {
    attach: function (context, settings) {
      var img = document.querySelectorAll(".wrapper-post img");
      var icon = document.querySelectorAll(".wrapper-post .icon");
      var liking = document.querySelectorAll(".flag-likes a");
      var touchtime = 0;
      var delay = 800;
      var action = null;
  
      // For triggering the like button.
      var unflag = document.querySelectorAll(".flag-likes");
      img.forEach((image,index) => {
        $(image).on("click", function() {
        // Double Click 
        // Comparing the current time with the after double click time. 
          if((new Date().getTime() - touchtime) < delay) {
            clearTimeout(action)
            icon[index].classList.add("like");
            // For updating CSS only when the image is not already liked.
            if(!unflag[index].classList.contains("action-unflag")) {
              liking[index].click()  
              // For updating the css.
              unflag[index].classList.add("action-unflag")
            }
            setTimeout(() => {
              icon[index].classList.remove("like");
            }, 1200);
              touchtime=0;
          }
          // Single Click 
          else {
            touchtime = new Date().getTime();
            action = setTimeout(function() {
            },delay);
          }
        });
      })
    }
  }
})(jQuery, Drupal);
