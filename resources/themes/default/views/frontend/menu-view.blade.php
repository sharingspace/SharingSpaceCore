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
                        @include('includes/side')
                        <!-- Tab panes -->
                        <div class="tab-content">
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