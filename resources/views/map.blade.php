<!DOCTYPE html>
<html>
<head>
    <title>Place Autocomplete</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
        html, body, #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px
        }
        .controls {
            margin: 6px 14px 14px 6px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            float: left;
        }

        #pac-input {
            /*background-color: #fff;*/
            /*font-family: Roboto;*/
            /*font-size: 15px;*/
            /*font-weight: 300;*/
            /*margin-left: 12px;*/
            /*padding: 0 11px 0 13px;*/
            text-overflow: ellipsis;
            width: 400px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        .pac-container {
            font-family: Roboto;
            z-index: 20;
        }

        #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
        }

        #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #map-canvas{
            height: 500px;
            width: 780px;
        }

        .clearfix {
            clear: both;
        }

        .button {
            padding: 4px;
            margin-top: 6px;
            min-width: 100px;
        }

        .modal{
            z-index: 20;
        }

        .modal-backdrop{
            z-index: 10;
        }​

    </style>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>

    <script>
        function initialize() {
            var mapOptions = {
                center: new google.maps.LatLng(-33.8688, 151.2195),
                zoom: 13,
                zIndex:9999
            };
            var map = new google.maps.Map(document.getElementById('map-canvas'),
                    mapOptions);

            var input = /** @type {HTMLInputElement} */(
                    document.getElementById('pac-input'));

            var types = document.getElementById('type-selector');
           // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
           // map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29),
                zIndex:9999
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);


    </script>
</head>
<body>

<input id="location_type" class="controls" type="text"
       placeholder="Enter a location type i.e Hospital,Hotel,etc" />

<input id="pac-input" class="controls" type="text"
       placeholder="Enter a location">

<button class="btnSavelocation button">Save</button>
<div class="clearfix"></div>
<div id="map-canvas"></div>

{{--<script src="http://code.jquery.com/jquery-2.1.1.js"></script>--}}
<script src="http://code.jquery.com/jquery-2.1.1.js"></script>

<script>
    $( ".btnSavelocation" ).click(function() {
        geocoder = new google.maps.Geocoder();
        var address = document.getElementById("pac-input").value;
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                data = [];

                $.post('geo_location',{
                    address: address,
                    latitude: results[0].geometry.location.lat(),
                    longitude:results[0].geometry.location.lng(),
                    location_type:$('#location_type').val()
                },function(data,status){

                });
            }
            else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    });

    $('#myModal').on('shown', function () {
        google.maps.event.trigger(map, "resize");
    });
</script>

</body>
</html>