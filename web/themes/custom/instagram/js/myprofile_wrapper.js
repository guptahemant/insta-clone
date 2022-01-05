  
    var x = window.matchMedia("(max-width: 425px)") ;
    x.addListener(myFun) ;// Attach listener function on state changes
    
    
    function myFun(x) {
      if (x.matches) { // If media query matches
        
        jQuery(document).ready(function($){
   
            $('#block-views-block-posts-count-block-1, #block-views-block-following-count-block-1, #block-views-block-followers-count-block-1').wrapAll('<div class="wrapcount" id="wrapcount" />');
     
            $('#block-views-block-myprofile-image-block-1, #block-views-block-myprofile-top-block-1').wrapAll('<div class="wrapper425" />');
                
            }); 
        } 
        else{ 
            jQuery(document).ready(function($){
    
                $('#block-views-block-posts-count-block-1, #block-views-block-following-count-block-1, #block-views-block-followers-count-block-1').wrapAll('<div class="wrapcount" id="wrapcount" />');
     
                $('#block-views-block-myprofile-top-block-1, #block-tabs, #wrapcount, #block-views-block-myprofile-bottom-block-1').wrapAll('<div class="wrapright" id="wrapright" />');
                 
                $('#block-views-block-myprofile-image-block-1, #wrapright').wrapAll('<div class="wrapper" />');
                 
                }); 
        }
    }
    
    let clock = setInterval(() => {
        clearInterval(clock)
        clock = null
        myFun(x); 
    }, 200)
    