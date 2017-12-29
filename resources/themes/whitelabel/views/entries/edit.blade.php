@extends('layouts/master')

{{-- Page title --}}
@section('title')
    {{ trans('general.entries.edit_entry') }} ::
    @parent
@stop

{{-- Page content --}}
@section('content')

    <!-- -->
    <section>
        <div id="edit_entry" class="container margin-top-20">
            <div class="row">
                <h1 class="margin-bottom-20 size-24 text-center">{{ trans('general.entries.edit_entry') }}</h1>
                <!-- Entry form -->
                @include('./entries/entry_form')
            </div>
        </div>
    </section>

@stop

@section('custom_js')
    <script type="text/javascript">
        $("#ajaxSubmit").attr('disabled', 'disabled'); // disable add button until page has loaded
        $("#create_table").hide(); // hide entry table
        $('#image_container').hide();
        $('#image_controls').hide();
        $('#cancel_button').show();
        var fileJustChosen = false;
        var reader = new FileReader(); // instance of the FileReader
        var rotationAngle = 0;
        var imageName = "{{$image}}";

        if ($('#entry_image_box').css('background-image') != 'none') {
            $('#entry_image_container').show();
        }
    </script>

    <script src="{{ Helper::cdn('js/entry_utils.js')}}"></script>

    @javascript('entry', $entry->toArray())

    <script type="text/javascript">
        $(document).ready(function () {
            createMapRenderer('entry_browse_map').then(function (map) {
                window.map = map
                window.map.setLatLng(parseFloat(mapLat), parseFloat(mapLng));

                if (window.entry.lat && window.entry.lng) {
                    window.entry.lon = window.entry.lng
                    window.entry.indoor = (window.entry.wrld3d && window.entry.wrld3d.indoor_id)
                    window.entry.indoor_id = window.entry.wrld3d ? window.entry.wrld3d.indoor_id : null
                    window.entry.floor_id = window.entry.wrld3d ? window.entry.wrld3d.indoor_floor : null
                    window.window.user_data = {
                        description: window.entry.description,
                        image_url: window.entry.image_url,
                        author_name: window.entry.display_name,
                        natural_post_type: window.entry.natural_post_type,
                        exchanges_types: window.entry.exchangesTypes,
                        url: window.entry.url,
                    };

                    if (window.entry.indoor) {
                        window.map.instance.indoors.on('indoorentranceadd', function () {
                            window.map.centerAt(window.entry);
                            window.map.enterBuilding(window.entry.indoor_id, window.entry.floor_id);
                        });

                        window.map.instance.indoors.on('indoormapenter', function () {
                            window.map.addMapMarker(window.entry, { popup: false, tooltip: false });
                        })
                    } else {
                        window.map.addMapMarker(window.entry, { popup: false, tooltip: false });
                    }
                }

                window.map.instance.on('dblclick', (ev) => {
                    var indoor = window.map.instance.indoors.getActiveIndoorMap()
                    var floor = window.map.instance.indoors.getFloor()

                    if (!window.entry.indoors) {
                        window.entry.indoors = {
                            id: null,
                            floor: null,
                        }
                    } else {
                        if (!window.entry.indoors.id) {
                            window.entry.indoors.id = null
                        }

                        if (!window.entry.indoors.floor) {
                            window.entry.indoors.floor = null
                        }
                    }

                    window.entry.location = ''
                    window.entry.lat = ev.latlng.lat
                    window.entry.lon = ev.latlng.lng
                    window.entry.indoor = indoor
                    window.entry.indoor_id = indoor === null ? '' : indoor.getIndoorMapId()
                    window.entry.floor_id = indoor === null ? '' : floor.getFloorIndex()

                    $('#location').val(window.entry.location)
                    $('#location_lat').val(window.entry.lat)
                    $('#location_lng').val(window.entry.lon)
                    $('#indoors_id').val(window.entry.indoor_id)
                    $('#indoors_floor').val(window.entry.floor_id)

                    window.map.removeMarkers()
                    window.map.addMapMarker(window.entry, { popup: false, tooltip: false })
                })
            })

            if (imageName.length > 0) {
                $("#delete_img_checkbox_label").show();
                var url = "url('/assets/uploads/entries/" + '{{$entry->id}}' + "/" + imageName + "?" + Date.now() + "')";
                $('#image_box').css("background-image", url);
                $('#image_container').show();
            }
        })
    </script>

@stop
