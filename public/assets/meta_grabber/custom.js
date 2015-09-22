/**
 * Created by pruthvi on 14/9/15.
 */
var meta_imgs = [];
$(document).ready(function(){
    $('#btn-get-meta').click(function(){
        var url = $('#meta-grabber-url').val();
        var data = $('#meta-grabber-form').serialize() ;

        if(!isValidURL(url)) {
            displayMessage('error','Invalid URL');
            return false;
        }

        ajaxSubmit(basePath+'getContent', 'mg-content', data);

        return false;
    });

    var currentindex = 0;
    $(".meta-grabber-nav-btn").click(function(){
        var nav = $(this).data('value');
        var index = $('#meta-grabber-img').data('value');

        if(nav == 'next') {
            currentindex = index+1;
        } else {
            if(currentindex > 0) {
                currentindex = index-1;
            }
        }

        $('#meta-grabber-img').data('value', currentindex);
        $('#meta-grabber-img').attr('src', meta_imgs[currentindex]);

        if(meta_imgs.length == currentindex || currentindex == 0) {
            $(this).attr('disabled', 'disabled');
        }
    });

    function isValidURL(url){
        var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

        if(RegExp.test(url)){
            return true;
        }else{
            return false;
        }
    }

    function ajaxSubmit(postUrl, div, data) {

        $.ajax({
            type: 'post',
            url: postUrl,
            data: data,
            beforeSend: function()
            {
                $('.meta-loader').show();
            },
            success: function(data)
            {
                var contentstr = "";
                if(data.success) {
                    $.each(data.meta,function(index,value){
                        contentstr += "<div><label>"+ index +"</label> " + value + "</div>";
                    });

                    meta_imgs = data.images;
                    if(meta_imgs) {
                        $('#meta-grabber-img').attr('src', meta_imgs[0]);
                        $('#meta-grabber-img').attr('data-value', 0);
                    }
                    $('.meta-message').hide();

                } else {
                    displayMessage('error','An unknown error occured. Please try again.');
                }

                $('.meta-loader').hide();
                $('#'+div).html(contentstr);
            }
        });
    }
    function displayMessage(type, msg) {
        switch (type) {
            case 'error':
                msg = "<div class='alert alert-warning'>"+msg+"</div>";
                break;
            case 'success':
                msg = "<div class='alert alert-success'>"+msg+"</div>";
                break;
        }
        $('.meta-message').html(msg);
        $('.meta-message').show();

    }
})
