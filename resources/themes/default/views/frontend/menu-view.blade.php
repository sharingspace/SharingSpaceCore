@extends('layouts/frontend-master')

@section('content')
<div id="main">
    <div class="clearfix">&nbsp;&nbsp;&nbsp;</div>
    <div class="section pb-10">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tabs vertical-tab mb-4">
                        <!-- Nav tabs -->
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs">
                                <li>
                                    <a href="#dashboard" data-toggle="tab">Dashboard</a>
                                </li>
                                <li>
                                    <a class="" href="#tab-content-11" data-toggle="tab">Pages</a>
                                </li>
                                <li>
                                    <a class="active" href="#tab-content-13" data-toggle="tab">Menus</a>
                                </li>
                                <li>
                                    <a href="#tab-content-13" data-toggle="tab">Tab 03</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade" id="dashboard">
                                <p>Dashboard is here</p>
                            </div>
                            <div class="tab-pane active fade show" id="tab-content-11">
                                <div class="col-sm-12">
                                    <div>
                                        <div  class="text-center">
                                            <h3 class="heading fw-normal fz-34">{{$module_subtitle}}</h3>
                                        </div>
                                        <div class="clearfix">&nbsp;&nbsp;</div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a href="{{ route('frontend.admin.menu') }}" class="btn btn-success btn-sm btn-flat ac_btn">
                                                  Back
                                                </a>
                                            </div>
                                        </div>
                                        <div class="clearfix">&nbsp;</div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="contact-form-wrapper">
                                                    @include("includes/message")

                                                    @if(isset($model))
                                                      {!! Form::model($model,['route' => 'frontend.post.control.menu.update' , 'method' => 'post','id'=>'form','files'=>true]) !!}
                                                      {!! Form::hidden('id', $model->id) !!}
                                                    @else    
                                                      {!! Form::open(['route' => 'frontend.admin.control.menu.post', 'method' => 'post','id'=>'form','files'=>true]) !!}
                                                    @endif
                                                      @include("frontend.menu-html")
                                                      {!! csrf_field() !!}
                                                      {{ Form::close() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="tab-content-13">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
@section('scripts')
<script src="/frontend/js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
    
</script>


@endsection