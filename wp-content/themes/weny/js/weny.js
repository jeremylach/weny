$(document).ready(function() {
    
    $('.fancybox').fancybox();

    $("#input_1_1").attr("placeholder", "Enter Email Address");

    $("#gform_1").submit(function() {
        //$("#interact .copy").fadeOut();
        //$(".gform_wrapper").css("border", "none");
        //event.preventDefault();
    });

    

    jQuery(document).bind('gform_post_data', function(event, formId){
        console.log("confirm");    // code to be trigger when confirmation page is loaded
    });
    $( document ).ajaxStart(function() {
        console.log('started');
    });

    ////PARALLAX STUFF
    //http://untame.net/2013/04/how-to-integrate-simple-parallax-with-twitter-bootstrap/
    // cache the window object
    $window = $(window);
 
    $('section[data-type="background"]').each(function(){
     // declare the variable to affect the defined data-type
        var $scroll = $(this);
                     
        $(window).scroll(function() {
        // HTML5 proves useful for helping with creating JS functions!
        // also, negative value because we're scrolling upwards                             
        var yPos = -($window.scrollTop() / $scroll.data('speed')); 
         
        // background position
        var coords = '50% '+ yPos + 'px';
 
        // move the background
        $scroll.css({ backgroundPosition: coords });    
        }); // end window scroll
    });  // end section function
});