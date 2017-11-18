@extends('layouts.master')
@section('content')

<!-- -->
<section>
    <div class="container margin-top-20 text-center">
        <div class="row text-muted">
            <div class="col-md-12">
                <p class="lead">{{ trans('coop.you_are_member')}}</p>
            </div>
            
            <p class="lead margin-bottom-50">{{ trans('coop.meantime')}}</p>
            
            <div class="col-md-6">
                <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//anysha.re/coop" target="_blank">
                <img class="coop-share-buttons" src="{{ Helper::cdn('img/coop/facebook-share-button.png') }}"></a>
            </div>
            <div class="col-md-6">
                <a href="https://twitter.com/home?status=I've%20just%20become%20an%20AnyShare%20Coop%20Member%20and%20support%20a%20fairer%20economy%20https%3A//anysha.re/coop%20%23platformcoop%20via%20%40anyshare_coop%20" target="_blank">
                <img class="coop-share-buttons" src="{{ Helper::cdn('img/coop/twitter-share-button.png') }}"></a>
            </div>
        </div>
    </div>
</section>
<!-- / -->

@section('moar_scripts')
@stop
@stop
