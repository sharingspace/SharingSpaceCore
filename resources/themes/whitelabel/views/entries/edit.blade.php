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
        window.map = createMapRenderer('entry_browse_map');

        window.map.setLatLng(parseFloat(mapLat), parseFloat(mapLng));

        if (entry.lat && entry.lng) {
            window.map.loadMarkers([entry], { popup: false, tooltip: false }).center();
        }

        if (imageName.length > 0) {
            $("#delete_img_checkbox_label").show();
            var url = "url('/assets/uploads/entries/" + '{{$entry->id}}' + "/" + imageName + "?" + Date.now() + "')";
            $('#image_box').css("background-image", url);
            $('#image_container').show();
        }
    </script>

@stop
