$(document).ready(function () {
    $.material.init();

    $('#form_validation').bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            txtName: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required'
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required'
                    }
                }
            },
            txtEmail: {
                validators: {
                    notEmpty: {
                        message: 'You need to enter a valid email address'
                    },
                    emailAddress: {
                        message: 'You need to enter a valid email address'
                    }
                }
            },
            display_name: {
                validators: {
                    notEmpty: {
                        message: 'Address line1 is required'
                    }
                }
            },
            display_name1: {
                validators: {
                    notEmpty: {
                        message: 'Address line2 is required'
                    }
                }
            },
            select_state: {
                validators: {
                    notEmpty: {
                        message: 'You must select a state'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Require a valid Phone number'
                    },
                    regexp: {
                        regexp: /^(\+?1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/,
                        message: 'Require a valid Phone number'
                    }
                }
            }

        }
    });
    $('#tryitForm').bootstrapValidator({
        fields: {
            firstName: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            lastName: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required and cannot be empty'
                    }
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'The gender is required'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'You need to enter a valid email address'
                    },
                    emailAddress: {
                        message: 'You need to enter a valid email address'
                    }
                }
            }

        },
        submitHandler: function (validator, form, submitButton) {
            var fullName = [validator.getFieldElements('firstName').val(),
                validator.getFieldElements('lastName').val()
            ].join(' ');
            $('#helloModal')
                .find('.modal-title').html('Hello ' + fullName).end()
                .modal();
        }
    });
    $('#form-validation1').bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            first_name: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required'
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required'
                    }
                }
            },
            display_name: {
                validators: {
                    notEmpty: {
                        message: 'Display name is required'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            password: {
                validators: {

                    different: {
                        field: 'first_name,last_name',
                        message: 'Password should not match first name or last name'
                    }
                },
                required: true,
                minlength: 3
            },

            confirmpassword: {
                validators: {
                    notEmpty: {
                        message: 'Confirm Password is required'
                    },
                    identical: {
                        field: 'password'
                    }
                }
            }
        }
    });
    $('#capch_form').bootstrapValidator({

        fields: {

            txtphone: {
                validators: {
                    notEmpty: {
                        message: 'Phone number is required'
                    }
                }
            },
            CaptchaCode: {
                validators: {
                    notEmpty: {
                        message: 'Please enter Captcha code'
                    }
                }
            }

        }
    });
    $('.BDC_CaptchaImageDiv').find('a').remove();

// form Validation Form  Reset
    $('#reset').on('click',function(){
        $('#form_validation').bootstrapValidator("resetForm",true);

        if($("#form_validation #chkConditions").prop('checked') == true){
            $("#form_validation").find(".checkbox-material").click();
        }
    });

// Validation in Modal Form  Reset
    $('.resetModal').on('click',function(){
        if($("#form-validation1 #terms").prop('checked') == true){
            $("#form-validation1").find(".checkbox-material").click();
        }
        $('#form-validation1').bootstrapValidator("resetForm",true);

    });
    // password validation
    if ($("#password1").val() == "" && $("#password2").val() == "") {
        $("#pwmatch").removeClass("material-icons").text("clear");
        $("#pwmatch").addClass("material-icons").text("done");
        $("#pwmatch").css("color", "#00A41E");
    }

    $("input[type=password]").keyup(function () {
        var ucase = new RegExp("[A-Z]+");
        var lcase = new RegExp("[a-z]+");
        var num = new RegExp("[0-9]+");

        if ($("#password1").val().length >= 8) {
            $("#8char").removeClass("material-icons").text("clear");
            $("#8char").addClass("material-icons").text("done");
            $("#8char").css("color", "#00A41E");
        } else {
            $("#8char").removeClass("material-icons").text("done");
            $("#8char").addClass("material-icons").text("clear");
            $("#8char").css("color", "#FF0004");
        }

        if (ucase.test($("#password1").val())) {
            $("#ucase").removeClass("material-icons").text("clear");
            $("#ucase").addClass("material-icons").text("done");
            $("#ucase").css("color", "#00A41E");
        } else {
            $("#ucase").removeClass("material-icons").text("done");
            $("#ucase").addClass("material-icons").text("clear");
            $("#ucase").css("color", "#FF0004");
        }

        if (lcase.test($("#password1").val())) {
            $("#lcase").removeClass("material-icons").text("clear");
            $("#lcase").addClass("material-icons").text("done");
            $("#lcase").css("color", "#00A41E");
        } else {
            $("#lcase").removeClass("material-icons").text("done");
            $("#lcase").addClass("material-icons").text("clear");
            $("#lcase").css("color", "#FF0004");
        }

        if (num.test($("#password1").val())) {
            $("#num").removeClass("material-icons").text("clear");
            $("#num").addClass("material-icons").text("done");
            $("#num").css("color", "#00A41E");
        } else {
            $("#num").removeClass("material-icons").text("done");
            $("#num").addClass("material-icons").text("clear");
            $("#num").css("color", "#FF0004");
        }

        if ($("#password1").val() == $("#password2").val()) {
            $("#pwmatch").removeClass("material-icons").text("clear");
            $("#pwmatch").addClass("material-icons").text("done");
            $("#pwmatch").css("color", "#00A41E");
        } else {
            $("#pwmatch").removeClass("material-icons").text("done");
            $("#pwmatch").addClass("material-icons").text("clear");
            $("#pwmatch").css("color", "#FF0004");
        }
        if ($("#password2").val().length = "") {
            $("#pwmatch").addClass("material-icons").text("clear");
            $("#pwmatch").css("color", "#FF0004");
        }


    });
    $('.input-group input[required], .input-group textarea[required], .input-group select[required]').on('keyup, change', function () {
        var $group = $(this).closest('.input-group'),
            $addon = $group.find('.input-group-addon'),
            $icon = $addon.find('span'),
            state = false;

        if (!$group.data('validate')) {
            state = $(this).val() ? true : false;
        } else if ($group.data('validate') == "email") {
            state = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())
        } else if ($group.data('validate') == 'phone') {
            state = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/.test($(this).val())
        } else if ($group.data('validate') == "length") {
            state = $(this).val().length >= $group.data('length') ? true : false;
        } else if ($group.data('validate') == "number") {
            state = !isNaN(parseFloat($(this).val())) && isFinite($(this).val());
        }

        if (state) {
            $addon.removeClass('danger');
            $addon.addClass('success');
            $icon.attr('class', 'material-icons').text("done");
        } else {
            $addon.removeClass('success');
            $addon.addClass('danger');
            $icon.attr('class', 'material-icons').text("clear");
        }
    });

    $("#form-valid").bootstrapValidator({
        fields: {
            txtName: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            lastName: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required and cannot be empty'
                    }
                }
            },
            txtEmail: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            addr1: {
                validators: {
                    notEmpty: {
                        message: 'The last address is required and cannot be empty'
                    }
                }
            },
            addr2: {
                validators: {
                    notEmpty: {
                        message: 'The last address is required and cannot be empty'
                    }
                }
            },
            chkConditions: {
                validators: {
                    choice: {
                        message: 'please check the Terms and Conditions'
                    }
                }
            },
            country: {
                validators: {
                    notEmpty: {
                        message: 'The country is required and can\'t be empty'
                    }
                }
            }
        }
    });

    // form validation field reset
    $('.form_validation_reset').click(function () {
        var $form = $('.form_validation');
        $form[0].reset();
        $form.find('input, select, textarea').change();
    });
});
$("input").on("keypress", function(e) {
    if (e.which === 32 && !this.value.length)
        e.preventDefault();

});

$('body').on('keyup','#form-validation1 input',function(){
    var pswd = $("#form-validation1 input[name='password']").val();
    var pswd_cnf = $("#form-validation1 input[name='confirmpassword']").val();

    if(pswd != '' ){
        $('#form-validation1').bootstrapValidator('revalidateField', 'password');
    }
    if(pswd_cnf != '' ){
        $('#form-validation1').bootstrapValidator('revalidateField', 'confirmpassword');
    }

});

