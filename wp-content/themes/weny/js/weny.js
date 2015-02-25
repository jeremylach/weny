$(document).ready(function() {
    
    var padding_array = [60, 40, 60, 40];
    if($(window).width() < 482) {
        padding_array = [30, 20, 30, 20];
    }

    $('.fancybox').fancybox( {
        closeBtn : false,
        wrapCSS: 'popup',
        maxWidth: 430,
        padding: padding_array//,
/*        afterLoad: function() {
            $(".gform_wrapper input:visible, .gform_wrapper textarea").on("focus", (function() {
                $(this).parent().parent().children(".validation_message").html("");
            }));
        }*/
    });

    $("#input_1_1").attr("placeholder", "Enter Email Address");
    
    $("#input_2_1").attr("placeholder", "Email Address");
    $("#input_2_2").attr("placeholder", "Enter Message");


    $("#gform_1").submit(function() {
        //$.fancybox.update();
        //event.preventDefault();
    });
    $("#gform_2").submit(function() {
        //event.preventDefault();
    });

    $("#logout").click(function() {
    
        jQuery.post(
            "../../../wp-admin/admin-ajax.php",
            {'action': 'logout'},
            function(response) {
                window.location.reload();
            }
        );
    });

    
    jQuery(document).bind('gform_confirmation_loaded', function(event, formId){
        console.log("confirm");    // code to be trigger when confirmation page is loaded
        $("#interact .copy").fadeOut();
    });

    $("#login form").submit(function() {
        event.preventDefault();

        $(".validation_message").html("");

        var user_email = $('#user_login').val();
        var user_pw = $("#user_pass").val();
        var valid = true;

        //Validate
        if(user_email == "" || !IsEmail(user_email)) {
            $(".email_error").html("Enter a valid email address");
            valid = false;
        }
        if(user_pw == "") {
            $(".pw_error").html("Enter a password");
            valid = false;
        }
        if(!valid) {
            return false;
        }
        var data = {
            'action': 'login',
            'log': user_email,
            'pwd': user_pw
        };
    
        jQuery.post(
            "../../../wp-admin/admin-ajax.php",
            data,
            function(response) {
                if (response == "success") {
                    window.location.reload();
                } else if(response.toLowerCase().indexOf("email") > -1) {
                    $(".email_error").html(response);
                } else {
                    $(".pw_error").html(response);
                }
            }
        );
    });


    $(".forgot-password #provide_email").submit(function() {
        

        var valid = true;

        $(".validation_message").html("");

        var user_email = $('#request_email').val();
        if(user_email == "" || !IsEmail(user_email)) {
            $(".email_error").html("Enter a valid email address");
            valid = false;
        }

        return valid;
    });

    $("#commentform").submit(function() {
        var valid = true;

        $(".validation_message").remove();

        var content = $('textarea#comment').val();
        if(content == "") {
            $(".comment-form-comment").append("<div class='validation_message comment_error'>Enter some text</div>");
            valid = false;
        }

        return valid;
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

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}