$(document).ready(function() {
    
    $('.fancybox').fancybox( {
        closeBtn : false,
        wrapCSS: 'popup',
        maxWidth: 430,
        padding: [60, 40, 60, 40]
    });

    $("#input_1_1").attr("placeholder", "Enter Email Address");
    
    $("#input_2_1").attr("placeholder", "Email Address");
    $("#input_2_2").attr("placeholder", "Enter Message");

    $("#gform_1").submit(function() {
        //$("#interact .copy").fadeOut();
        //$(".gform_wrapper").css("border", "none");
        //event.preventDefault();
    });

    
    jQuery(document).bind('gform_confirmation_loaded', function(event, formId){
        console.log("confirm");    // code to be trigger when confirmation page is loaded
        $("#interact .copy").fadeOut();
    });

    $("#gform_2").submit(function() {
        //$("#interact .copy").fadeOut();
        //$(".gform_wrapper").css("border", "none");
        //event.preventDefault();
        //$(".popup .fancybox-inner").css("overflow", "hidden");
        ///$.fancybox.update();
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