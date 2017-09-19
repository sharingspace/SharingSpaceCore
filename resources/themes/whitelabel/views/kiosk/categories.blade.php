@extends('layouts.kiosk')

@section('content')

<section class="container-fluid padding-top-0">
  <div class="row margin-top-20">
  <?php
    if (count($entryList)) {
        foreach($entryList as $entry) {
            echo '<div class="col-xs-4 center-img-text padding-y-15">
            <div class="tint '.$entry['tint_shade'].'">
                <a href="'.route("_kiosk_categories", ["tag" => $entry["tag"]]).'">
                    <img class="img-responsive" src="'.$entry['image'].'">
                </a>
                </div>
                <div class="center-block text">
                    '.$entry['tag'].'
                </div>
            </div>';
        }
    }
    else {
        echo '<h1 class="text-center">No Categories Found</h1>';
    }
  ?>
  </div>
</section>


<script type="text/javascript">
$( document ).ready(function() {
  $(".center-img-text").click(function() {
    window.location = $(this).find("a").attr("href"); 
    return false;
  });
})
</script>

@stop
