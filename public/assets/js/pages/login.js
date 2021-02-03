$("#authentication").bootstrapValidator({
    fields: {
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
                notEmpty: {
                    message: 'Password is required'
                }

            }
        }
    }
});
$("#reset_pw").bootstrapValidator({
    fields: {
        email: {
            validators: {
                notEmpty: {
                    message: 'A registered email address is required'
                },
                emailAddress: {
                    message: 'The input is not a valid email address'
                }
            }
        }
    }
});

$("#register_here").bootstrapValidator({
    fields: {
        first_name: {
            validators: {
                notEmpty: {
                    message: 'First name is required'
                }
            },
            required: true,
            minlength: 3
        },
        last_name: {
            validators: {
                notEmpty: {
                    message: 'Last name is required'
                }
            },
            required: true,
            minlength: 3
        },
        email: {
            validators: {
                notEmpty: {
                    message: 'The email address is required'
                },
                regexp: {
                    regexp: /^(\w+)([\-+.\'0-9A-Za-z_]+)*@(\w[\-\w]*\.){1,5}([A-Za-z]){2,6}$/,
                    message: 'The input is not a valid email address'
                }

            }
        },
        email_confirm: {
            validators: {
                notEmpty: {
                    message: 'The confirm email address is required'
                },
                identical: {
                    field: 'email',
                    message: 'Entered email is not matching with your email'
                }
            }
        },
        password: {
            validators: {
                notEmpty: {
                    message: 'Password is required'
                },
                different: {
                    field: 'first_name,last_name',
                    message: 'Password should not match first name or last name'
                }
            }
        },
        password_confirm: {
            validators: {
                notEmpty: {
                    message: 'Confirm Password is required'
                },
                identical: {
                    field: 'password',
                    message: 'Confirm Password should match with password'
                }
            }
        }
    }
});
$('#register_here input').on('keyup', function (){

    var pswd = $("#register_here input[name='password']").val();
    var pswd_cnf = $("#register_here input[name='password_confirm']").val();
    var email_cnf = $("#register_here input[name='email_confirm']").val();

        if(pswd != '' ){
            $('#register_here').bootstrapValidator('revalidateField', 'password');
        }
        if(pswd_cnf != '' ){
            $('#register_here').bootstrapValidator('revalidateField', 'password_confirm');
        }
        if(email_cnf != '' ){
            $('#register_here').bootstrapValidator('revalidateField', 'email_confirm');
        }

});

setTimeout(function() {
    $("#notific").remove();
}, 5000);