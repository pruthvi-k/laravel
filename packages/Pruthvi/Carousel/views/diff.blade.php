@if ($template)
    @extends("audit::$template")
@endif
<link rel="stylesheet" href="{{ url("/assets/diffview.css") }}">
<link rel="stylesheet" href="{{ url("/assets/custom.css") }}">
@section('content')
    <div style="visibility: hidden;position: absolute;">
        <div class="textInput">
            <h2>Base Text</h2>
            <textarea id="baseText">{{isset($data[1])? $data[1] : ''}}</textarea>
        </div>
        <div class="textInput spacer">
            <h2>New Text</h2>
            <textarea id="newText">{{$data[0]}}</textarea>
        </div>
    </div>
    <div class="viewType">
        <input type="radio" name="_viewtype" id="sidebyside" onclick="diffUsingJS(0);" /> <label for="sidebyside">Side by Side Diff</label>
        &nbsp; &nbsp;
        <input type="radio" name="_viewtype" id="inline" onclick="diffUsingJS(1);" /> <label for="inline">Inline Diff</label>
    </div>
    <div id="diffoutput"> </div>

    <script src="{{ url("/assets/diffview.js") }}"></script>
    <script src="{{ url("/assets/difflib.js") }}"></script>

    <script type="text/javascript">

        function diffUsingJS(viewType) {
            "use strict";
            var byId = function (id) {
                        return document.getElementById(id);
                    },
                    base = difflib.stringAsLines(byId("baseText").value),
                    newtxt = difflib.stringAsLines(byId("newText").value),
                    sm = new difflib.SequenceMatcher(base, newtxt),
                    opcodes = sm.get_opcodes(),
                    diffoutputdiv = byId("diffoutput"),
                    contextSize = '';//byId("contextSize").value;
            diffoutputdiv.innerHTML = "";
            contextSize = contextSize || null;

            diffoutputdiv.appendChild(diffview.buildView({
                baseTextLines: base,
                newTextLines: newtxt,
                opcodes: opcodes,
                baseTextName: "Base Text: " + "<?php //echo $data['revision1'];?>",
                newTextName: "New Text: " + "<?php //echo $data['revision0'];?>",
                contextSize: contextSize,
                viewType: viewType
            }));
        }

        document.onreadystatechange = function () {
            diffUsingJS(0);
        };

    </script>
@endsection

