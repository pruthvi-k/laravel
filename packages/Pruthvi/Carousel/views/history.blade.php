@if ($template)
    @extends("audit::$template")
@endif
<link rel="stylesheet" href="{{ url("/assets/diffview.css") }}">
<link rel="stylesheet" href="{{ url("/assets/custom.css") }}">
@section('content')
    <h3>Content History</h3>
    <div class="col-md-10">
        <table class="table table-striped" id="myTable">
            <tr>
                <th>#</th>
                <th>Revision No.</th>
                <th>Content Type</th>
                <th>Date</th>
                <th>Diff</th>
            </tr>
            @foreach($historyData as $history)

                <tr>
                    <td>{{$history->id}}</td>
                    <td>{{$history->revision_no}}</td>
                    <td>{{$history->content_type}}</td>
                    <td>{{$history->created_at}}</td>
                    <td><a href="{{ URL::action('\Focalworks\Audit\Http\Controllers\AuditController@diff',
                        ['id' => $history->id])
                   }}">View</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
<script src="{{ url("/assets/diffview.js") }}"></script>
<script src="{{ url("/assets/difflib.js") }}"></script>