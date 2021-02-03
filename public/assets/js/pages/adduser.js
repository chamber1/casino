$(document).ready(function() {
    $.material.init();
// bootstrap wizard//
    $(".select21").select2({
        theme: "bootstrap",
        placeholder: "",
        width: '100%'
    });
    $("#dob").datetimepicker({
        format: 'YYYY-MM-DD',
        widgetPositioning: {
            vertical: 'bottom'
        },
        keepOpen: false,
        useCurrent: false,
        maxDate: moment().add(1,'h').toDate()
    });
    $("#commentForm").bootstrapValidator({
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
                        field: 'password'
                    },
                    different: {
                        field: 'first_name,last_name',
                        message: 'Confirm Password should match with password'
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
            bio: {
                validators: {
                    notEmpty: {
                        message: 'The Bio data field is required'
                    }
                }
            },
            group: {
                validators: {
                    notEmpty: {
                        message: 'You must select a group'
                    }
                }
            }
        }
    });


    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'onNext': function (tab, navigation, index) {
            var $validator = $('#commentForm').data('bootstrapValidator').validate();
            return $validator.isValid();
        },

        onTabClick: function (tab, navigation, index) {
            return false;
        },
        onTabShow: function (tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;

            // If it's the last tab then hide the last button and show the finish instead
            if ($current >= $total) {
                $('#rootwizard').find('.pager .next').hide();
                $('#rootwizard').find('.pager .finish').show();
                $('#rootwizard').find('.pager .finish').removeClass('disabled');
            } else {
                $('#rootwizard').find('.pager .next').show();
                $('#rootwizard').find('.pager .finish').hide();
            }
        }
    });

    $('#rootwizard .finish').click(function () {
        var $validator = $('#commentForm').data('bootstrapValidator').validate();
        if (( document.commentForm.activate.checked == false )) {
            $('#editConfirmModal').modal();
        }
        else {
            if ($validator.isValid()) {
                document.getElementById("commentForm").submit();
            }
        }
    });

});
$("input").on("keypress", function(e) {
    if (e.which === 32 && !this.value.length)
        e.preventDefault();
});
