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
                                                <a href="{{ route('frontend.admin.control') }}" class="btn btn-success btn-sm btn-flat ac_btn">
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
                                                      {!! Form::model($model,['route' => 'frontend.post.control.edit' , 'method' => 'post','id'=>'form','files'=>true]) !!}
                                                      {!! Form::hidden('id', $model->id) !!}
                                                    @else    
                                                      {!! Form::open(['route' => 'frontend.admin.control.post', 'method' => 'post','id'=>'form','files'=>true]) !!}
                                                    @endif
                                                      @include("frontend.control-html")
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
    tinymce.init({
        selector: '#file',
        height: 150,
        theme: 'modern',
        plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
            ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
        image_advtab: true,
        templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
          
        content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
    });


    $(document).on("keyup",".name_title",function(e){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $('.slug_name').val(Text);
    });
</script>


@endsection