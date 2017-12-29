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
                    window.map.loadMarkers([window.entry], { popup: false, tooltip: false }).center();
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
                    window.entry.latitude = ev.latlng.lat
                    window.entry.longitude = ev.latlng.lng
                    window.entry.indoors.id = indoor === null ? '' : indoor.getIndoorMapId()
                    window.entry.indoors.floor = indoor === null ? '' : floor.getFloorIndex()

                    $('#location').val(window.entry.location)
                    $('#location_lat').val(window.entry.latitude)
                    $('#location_lng').val(window.entry.longitude)
                    $('#indoors_id').val(window.entry.indoors.id)
                    $('#indoors_floor').val(window.entry.indoors.floor)

                    window.map.loadMarkers([window.entry], { popup: false, tooltip: false })
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
