  
    var x = window.matchMedia("(max-width: 425px)") ;
    x.addListener(myFun) ;// Attach listener function on state changes
    
    
    function myFun(x) {
      if (x.matches) { // If media query matches
        
        jQuery(document).ready(function($){
   
            $('article, .wrapright').wrapAll('<div class="wrapper" />');
            $('.uname, .settings').wrapAll('<div class="wraptop" />');
            $('.bottom, .wrapcount').wrapAll('<div class="bottomwrap" />');

            }); 
        } 
        else{ 
            jQuery(document).ready(function($){
    
            $('article, .wrapright').wrapAll('<div class="wrapper" />');

            }); 
        }
    }
    
    let clock = setInterval(() => {
        clearInterval(clock)
        clock = null
        myFun(x); 
    }, 200)
    