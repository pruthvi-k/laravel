<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ URL::action('\Focalworks\Audit\Http\Controllers\AuditController@history','all')}}">History</a>
            </li>
            <li>
                <a href="#">Content Types</a>

                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ URL::action('\Focalworks\Audit\Http\Controllers\AuditController@history','all')}}">All</a>
                    </li>
                    @if($contentTypes)
                        @foreach($contentTypes as $content)
                            <li>
                                <a href="{{ URL::action('\Focalworks\Audit\Http\Controllers\AuditController@history',$content->content_type)}}">{{ucwords($content->content_type)}}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
                <!-- /.nav-second-level -->
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>