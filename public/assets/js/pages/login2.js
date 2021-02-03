$(document).ready(function () {

    $("#authentication").bootstrapValidator({
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Enter a valid email address'
                    },
                    emailAddress: {
                        message: 'Enter a valid email address'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Password is required'
                    }

                }
            }
        }
    });
    var height = $(window).height();
    $('body').css('min-height',height);

    $(document).mousemove(function (event) {
        TweenLite.to($('body'), .5, {css: {'background-position': parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / 12) + "px, " + parseInt(event.pageX / 15) + "px " + parseInt(event.pageY / 15) + "px, " + parseInt(event.pageX / 30) + "px " + parseInt(event.pageY / 30) + "px"}});
    });
});