@extends('layouts.master')

@section('content')

<section>
  <div class="container">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 text-center">
        <h2 class="section-title" style="text-align:center;">{{trans('home.share_heading')}}</h2>
        <div class="row uses-row">
          <div class="col-md-4"><img src="{{ Helper::cdn('img/hp/earth_between_hands.png') }}" class="use-icon">
            <h3>{{trans('home.platform')}}</h3>
            <p>{{trans('home.platform_description')}}</p>
          </div>
          <div class="col-md-4"><img src="{{ Helper::cdn('img/hp/hands_around_people.png') }}" class="use-icon">
            <h3>{{trans('home.local')}}</h3>
            <p>{{trans('home.local_description')}}</p>
          </div>
          <div class="col-md-4"><img src="{{ Helper::cdn('img/hp/people.png') }}" class="use-icon">
            <h3>{{trans('home.crowdsource')}}</h3>
            <p>{{trans('home.crowdsource_description')}}</p>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<section id="case_studies">
  <div class="container">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 text-center">
        <h2 class="section-title" style="text-align:center;">{{trans('home.case_studies')}}:</h2>
        <div class="row uses-row">
          <div class="col-md-4">
            <div class="case_study">
              <a href="" data-toggle="modal" data-target="#caseStudy1">
                <img src="{{ Helper::cdn('img/hp/fs_case_study_thumb.jpg') }}" class="use-icon">
                <h3>{{trans('home.case_study_title_1')}}</h3>
              </a>
            </div>
            <p>{{trans('home.case_study_desc_1')}}</p>
          </div>
          <div class="col-md-4">
            <div class="case_study">
              <a href="" data-toggle="modal" data-target="#caseStudy2">
                <img src="{{ Helper::cdn('img/hp/arco_case_study_thumb.jpg') }}" class="use-icon">
                <h3>{{trans('home.case_study_title_2')}}</h3>
              </a>
            </div>
            <p>{{trans('home.case_study_desc_2')}}</p>
          </div>
          <div class="col-md-4">
            <div class="case_study">
              <a href="" data-toggle="modal" data-target="#caseStudy3">
                <img src="{{ Helper::cdn('img/hp/czech_case_study_thumb.jpg') }}" class="use-icon">
                <h3>{{trans('home.case_study_title_3')}}</h3>
              </a>
            </div>
            <p>{{trans('home.case_study_desc_3')}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta">
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <div class="row">
          <div class="col-sm-9 col-xs-12 margin-bottom-0">
            <h2 class="white-secondary-heading">{{trans('general.make_share_now')}}</h2>
          </div>
          <div class="col-sm-3 col-xs-12 margin-bottom-0">
            <a href="{{ route('community.create.form') }}" class="btn center-xs pull-right-sm size-18 weight-700 font-smoothing" style="background-color:black;color:white">{{ trans('general.nav.start_now') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="caseStudy2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('home.case_study_popup_title_2')}}</h4>
      </div>
      <div class="modal-body">
      <img src="{{ Helper::cdn('img/hp/arco_case_study_modal.jpg') }}">
        <p>{{ trans('home.case_study_popup_2')}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
      </div>
    </div>
  </div>
</div>

<div id="caseStudy3" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('home.case_study_popup_title_3')}}</h4>
      </div>
      <div class="modal-body">
        <img src="{{ Helper::cdn('img/hp/czech_case_study_modal.png') }}">
        <p>{{ trans('home.case_study_popup_3')}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
      </div>
    </div>
  </div>
</div>

<div id="caseStudy1" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ trans('home.case_study_popup_title_1')}}</h4>
      </div>
      <div class="modal-body">
        <img src="{{ Helper::cdn('img/hp/fs_case_study_modal.png') }}">
        <p>{{ trans('home.case_study_popup_1')}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
      </div>
    </div>
  </div>
</div>
@section('moar_scripts')
@stop

@stop
