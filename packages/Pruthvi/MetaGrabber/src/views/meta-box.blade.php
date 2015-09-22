@if ($template)
    @extends("metagrabber::$template")
@endif
<script>
    var basePath = "{{ url("meta/") }}/";
</script>
<link rel="stylesheet" href="{{ url("/assets/meta_grabber/style.css") }}">
@section('meta-grabber')
    <h3>Meta Grabber Demo</h3>
    <div class="row">
        <form action="{{ url('meta/getContent')  }}" method="POST" class="form-horizontal" id="meta-grabber-form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="navbar-form row" role="search">

                <div class="form-group">
                    <input id="meta-grabber-url" class="form-control" type="text" name="meta-grabber-url" value=""/>
                </div>

                <button id="btn-get-meta" class="btn btn-default">Get</button>

            </div>
            <div class="meta-loader"></div>
            <div class="meta-message"></div>
            <div id="meta-grabbed-content"  class="row">

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

</style>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript" src="{{ url("/assets/meta_grabber/custom.js") }}">

</script>