<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=places&amp;sensor=false&amp;key={{ config('services.google_maps.api_key') }}"></script>
<script>
    $(function () {
        function initialize () {
            var input = document.getElementById('location');

            if (input) {
                var autocomplete = new google.maps.places.Autocomplete(input);

                autocomplete.addListener('place_changed', function () {
                    var place = autocomplete.getPlace();

                    if (!place.geometry) {
                        return;
                    }

                    var lat = place.geometry.location.lat();
                    var lng = place.geometry.location.lng();

                    $('#location_lat').val(lat);
                    $('#location_lng').val(lng);

                    window.entry.lat = lat;
                    window.entry.lng = lng;

                    window.map.setLatLng(lat, lng).loadMarkers([window.entry], { popup: false, tooltip: false }).center();
                });

                $('#location').on('keyup keypress', function (e) {
                    var keyCode = e.keyCode || e.which;
                    if (keyCode === 13) {
                        e.stopPropagation();
                        e.preventDefault();
                    }
                });
            }
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    });
</script>

<script src="//www.google.com/jsapi"></script>

<script>

    "use strict";
    $(document).ready(function () {
        // wire up button click
        $('#geolocate').click(function () {
            // test for presence of geolocation
            if (navigator && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(geo_success, geo_error);

                // Fall back to Google
            } else {
                if ((typeof google == 'object') && google.loader && google.loader.ClientLocation) {
                    var myLocation = {
                        "lat": google.loader.ClientLocation.latitude,
                        "lng": google.loader.ClientLocation.longitude
                    }

                    geo_success(myLocation);
                } else {
                    geo_error(4);
                    console.log('Geolocation is not supported.');
                }

            }
        });
    });

    function geo_success (position) {
        // printLatLong(position.coords.latitude, position.coords.longitude);
        printAddress(position.coords.latitude, position.coords.longitude);
    }

    // use Google Maps API to reverse geocode our location
    function printAddress (latitude, longitude) {
        // set up the Geocoder object
        var geocoder = new google.maps.Geocoder();

        // turn coordinates into an object
        var yourLocation = new google.maps.LatLng(latitude, longitude);

        // find out info about our location
        geocoder.geocode({ 'latLng': yourLocation }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var street = results[0].address_components[1].short_name;
                    var city = results[0].address_components[2].short_name;
                    var state = results[0].address_components[5].short_name;
                    $('#location').val(street + ' ' + city + ', ' + state);

                    //$('#location').val(results[0].formatted_address);
                    $('#geolocate').css('color', 'green');
                } else {
                    console.log('Google did not return any results.');
                }
            } else {
                console.log("Reverse Geocoding failed due to: " + status);
            }
        });

    }


    // The PositionError object returned contains the following attributes:
    // code: a numeric response code
    // PERMISSION_DENIED = 1
    // POSITION_UNAVAILABLE = 2
    // TIMEOUT = 3
    // message: Primarily for debugging. It's recommended not to show this error
    // to users.
    function geo_error (err) {
        /* Uncomment to debug
        if (err.code == 1) {
            console.log('The user denied the request for location information.')
        } else if (err.code == 2) {
            console.log('Your location information is unavailable.')
        } else if (err.code == 3) {
            console.log('The request to get your location timed out.')
        } else if (err.code == 4) {
            console.log('Google fallback is donked.')
        } else {
            console.log('An unknown error occurred while requesting your location.')
        }
        */
    }


</script>
