$(function() {
    $( ".image-select" ).click(function() {
        $('.fileupload-preview').remove();
    });

    //Code for collpasing panels

    $(document).on('click', '.panel-heading .removepanel', function(){
        var $this = $(this);
        $this.parents('.panel').hide("slow");
    });

    //panel hide
    $('.showhide').attr('title','Hide Panel content');
    $(document).on('click', '.clickable', function(e){
        var $this = $(this);
        if(!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.find('i').removeClass('material-icons').text("keyboard_arrow_up").addClass('material-icons').text("keyboard_arrow_down");
            $('.showhide').attr('title','Show Panel content');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.find('i').removeClass('material-icons').text("keyboard_arrow_down").addClass('material-icons').text("keyboard_arrow_up");
            $('.showhide').attr('title','Hide Panel content');
        }
    });


    // UPLOAD
    $(document).ready(function() {

        $('#upload_gallery').fileupload({
            dataType: 'json',
            add: function (e, data) {
                $('.loading').html('LOADING.....');
                data.submit();
            },
            done: function (e, data) {
                $('.loading').html('');
                if(data.result.success) {
                    $('#image-list').append('<li id="image_'+data.result.id+'" ><img src="'+data.result.path+'" ><a href="javascript:void(0)" onclick="return deleteImage('+data.result.id+')" ><i class="fa fa-trash"></i></a></li>');
                }
            }
        });

    });


    // END UPLOAD


});
