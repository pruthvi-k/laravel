@extends("metagrabber::master")
@section('meta-grabber')
    <h3>Meta Grabber Demo</h3>
    <div class="row">
        <form action="{{ url('meta/show')  }}" method="POST" class="form-horizontal" id="meta-grabber-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="navbar-form navbar-left" role="search">
                <div class="form-group"><input id="meta-grabber-url" class="form-control" type="text" name="meta-grabber-url" value=""/></div>
                <button id="btn-get-meta" class="btn btn-default">Get</button>
            </div>
            <div class="meta-loader"></div>
            <div class="meta-message"></div>
            <div id="meta-grabbed-content" class="col-md-12">

                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img data-holder-rendered="true" id="meta-grabber-img" data-value="0" class="img-responsive center-block" >
                    </div>

                        <nav>
                            <ul class="pager">
                                <li><a href="#" class="meta-grabber-nav-btn" data-value="prev">Previous</a></li>
                                <li><a href="#" class="meta-grabber-nav-btn" data-value="next">Next</a></li>
                            </ul>
                        </nav>

                </div>



                {{--<div id="mg-img" class="col-md-4"></div>--}}
                <div id="mg-content" class="col-md-8">
                </div>
            </div>
        </form>


    </div>
@endsection
<style>
    #meta-grabber-img{
        max-height: 200px;
        max-width: 200px;
    }
    .thumbnail{
        padding: 10px;
        height: 340px;
        width: 340px;
        align-items: center;
        vertical-align: middle;
        background: #e3e3e3;
    }
    .thumbnail img{
        margin: 0 auto;
    }
</style>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
    var meta_imgs = [];
    $(document).ready(function(){
        $('#btn-get-meta').click(function(){
            var url = $('#meta-grabber-url').val();
            var data = $('#meta-grabber-form').serialize() ;

            if(!isValidURL(url)) {
                displayMessage('error','Invalid URL');
                return false;
            }

            ajaxSubmit('{{ url("meta/getContent") }}', 'mg-content', data);
            {{--ajaxSubmit('{{ url("meta/getImages") }}', 'mg-content', data);--}}

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
                        console.log('',meta_imgs);
                    }

                    $('.meta-loader').hide();
                    $('#'+div).html(contentstr);
                },
                error: function()
                {
                    displayMessage('error','error');
                }
            });
        }
        function displayMessage(type, msg) {
            $('.meta-message').html(msg);
        }
    })
</script>