@extends('layouts/master')

{{-- Page title --}}
@section('title')
    {{ trans('general.community.settings') }} ::
    @parent
@stop


{{-- Page content --}}
@section('content')

    <section class="container">

        <div id="edit_wrapper" class="container margin-top-20">
            <div class="row">
                <h1 class="margin-bottom-0 size-24 text-center">{{ trans('general.community.settings') }}</h1>

                <!-- Entry -->
                <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
                    <ul class="nav nav-tabs nav-top-border">
                        <li class="active"><a href="#info" data-toggle="tab">{{trans('general.community.basic')}}</a></li>
                        <li><a href="#hub_images" data-toggle="tab">{{trans('general.community.images')}}</a></li>
                        <li><a href="#advanced" data-toggle="tab">{{trans('general.community.advanced')}}</a></li>
                    </ul>

                    <form method="post" action="{{ route('community.edit.save') }}" enctype="multipart/form-data" autocomplete="off">
                        {!! csrf_field() !!}
                        <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="4096000"/>
                        <div class="tab-content margin-top-20">
                            <!-- PERSONAL INFO TAB -->
                            <div class="tab-pane fade in active" id="info">
                                <h2 class="size-16 uppercase">{{trans('general.community.edit_hub')}}</h2>
                                <div class="alert alert-danger" style="display:none" id="submission_error"></div>

                                <!-- community form -->
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <fieldset class="nomargin">
                                            <div class="form-group{{ $errors->first('name', ' has-error') }}">
                                                <label class="control-label" for="name">{{trans('general.community.name')}} *</label>
                                                <input type="text" name="name" class="form-control" placeholder="{{trans('general.community.name_placeholder')}}" required="" value="{{ Input::old('name', $community->name) }}">
                                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                            </div> <!-- form-group -->
                                        </fieldset>

                                        <!-- Slug -->
                                        <div class="form-group{{ $errors->first('subdomain', ' has-error') }}">
                                            <label for="subdomain">{{trans('general.community.subdomain')}} *</label>
                                            <input type="text" name="subdomain" class="form-control" placeholder="{{trans('general.community.subdomain_placeholder')}}" required=""
                                                   value="{{ Input::old('subdomain', $community->subdomain) }}">
                                            {!! $errors->first('subdomain', '<span class="help-block">:message</span>') !!}
                                        </div>

                                        <!-- Type -->
                                        <div class="form-group">
                                            <label for="group_type">{{trans('general.community.type')}} *
                                                <button type="button" class="" data-toggle="modal" data-target="#privacyLevelModal"><i class='fa fa-info-circle'></i></button>
                                            </label>
                                            {!! Form::community_types('group_type', Input::old('group_type', $community->group_type)) !!}
                                            {!! $errors->first('group_type', '<span class="help-block">:message</span>') !!}
                                        </div> <!-- Type -->

                                        <!-- Description -->
                                        <div class="form-group {{ $errors->first('about', 'has-error') }}">
                                            <label class="input">{{trans('general.community.description')}} ({{trans('general.markdown')}} <a target="_blank" href="
https://anyshare.freshdesk.com/support/solutions/articles/17000035463-using-markdown" target="_blank"><i class='fa fa-info-circle'></i></a> )
                                                <textarea name="about" rows="5" class="form-control" data-maxlength="200" id="about" data-info="textarea-words-info"
                                                          placeholder="{{trans('general.community.detailed_description')}}">{{ Input::old('about', $community->about) }}</textarea>
                                            </label>
                                        </div> <!-- Description -->

                                        <!-- Location -->
                                        <div class="form-group {{ $errors->first('location', 'has-error') }}">
                                            <label class="control-label sr-only" for="location">Location</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="location" name="location" placeholder="Near (optional)" aria-describedby="basic-addon2"
                                                       value="{{{ Input::old('location', $community->location) }}}">
                                                <div class="input-group-addon" id="basic-addon2">
                                                    <i class="fa fa-location-arrow" id="geolocate"></i>
                                                </div>
                                                {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div> <!-- Location -->

                                        <label for="theme_color">{{trans('general.color.color_theme')}}</label>
                                        {!! Form::theme_color('theme_color', Input::old('color', $community->color)) !!}
                                        {!! $errors->first('color', '<span class="help-block">:message</span>') !!}


                                        <label for="entry_layout" class="margin-top-15">{{trans('general.community.entry_layout')}}</label>
                                    {!! Form::entry_layout('entry_layout', Input::old('entry_layout', $community->entry_layout)) !!}
                                    {!! $errors->first('entry_layout', '<span class="help-block">:message</span>') !!}

                                    <!-- <label class="margin-top-15" for="info_bar" style="display: block;">
                    Hide home page information bar?
                    <input name="show_info_bar" type="checkbox" value="0"
                    @if (!$whitelabel_group->show_info_bar)
                                        checked
@endif
                                            >
                                            <button type="button" class="" data-toggle="modal" data-target="#infoBarModal">
                                              <i style='color:#5bc0de;' class='fa fa-info-circle'></i>
                                            </button>
                                          </label>  -->
                                    </div> <!-- col-md-8 -->

                                    <div class="col-md-4 col-sm-4 col-xs-12" style="border-right:#CCC thin solid;">
                                        <div class="form-group" style="margin-bottom: 5px;">
                                            <fieldset class="margin-bottom-10">

                                                <legend class="size-14"><p>{{trans('general.community.exchange_options')}}</p></legend>
                                                {{ $errors->first('tile_exchange_type', '<div class="alert-no-fade alert-danger col-sm-12"><i class="icon-remove-sign"></i> :message</div>') }}
                                                <div class="exchange_types">
                                                    <!-- checkboxes for exchange types -->
                                                    <div class="checkbox">
                                                        <div class="row">

                                                            @foreach (\App\Models\ExchangeType::all() as $exchange_types)
                                                                <div class="col-xs-12 pull-left margin-bottom-10">
                                                                    <label class="checkbox pull-left margin-bottom-10">
                                                                        @if (array_key_exists($exchange_types->id, $allowed_exchanges))
                                                                            {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, true,
                                                                            ['class' => 'exchanges']) }}
                                                                        @else
                                                                            {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, false,
                                                                            ['class' => 'exchanges']) }}
                                                                        @endif
                                                                        <i></i>{{ $exchange_types->name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach

                                                            <div class="col-xs-12 pull-left margin-bottom-10">
                                                                <label class="checkbox pull-left margin-bottom-10">
                                                                    {{ Form::checkbox('select_all', 10, false, ['id' => 'select_all']) }}
                                                                    <i></i> {{trans('general.community.all_exchanges')}}
                                                                </label>
                                                            </div> <!-- col-md-12 -->
                                                        </div> <!-- row -->
                                                    </div> <!-- checkbox -->
                                                </div> <!-- exchange_types -->
                                            </fieldset>
                                        </div> <!-- form-group -->
                                    </div> <!-- col-md-4 -->
                                </div> <!-- row -->
                            </div> <!-- PERSONAL INFO TAB -->

                            <!-- IMAGES TAB -->
                            <div class="tab-pane fade" id="hub_images">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- Cover upload -->
                                        <div class="form-group {{ $errors->first('file', 'has-error') }}">
                                            <label for="cover_img">{{ trans('general.uploads.cover_image') }}</label>
                                            <div class="fancy-file-upload fancy-file-info">
                                                <i class="fa fa-picture-o"></i>
                                                <input type="file" class="form-control" id="cover_img" name="cover_img" onchange="jQuery(this).next('input').val(this.value);"/>
                                                <input type="text" class="form-control" id="cover_shadow_input" placeholder="{{ trans('general.entries.file_placeholder')}}" readonly=""/>
                                                <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                                            </div>
                                            <p class='too_large_cover smooth_font' style="display:none;font-size:30px">{{ trans('general.entries.max_file_size')}}</p>
                                            <p>{{ trans('general.uploads.banner_tip')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-md-offset-1 col-xs-12 margin-bottom-30">
                                        <img src="{{ $whitelabel_group->getCover() }}" style=" width: 100%;height: 100%;object-fit:cover;overflow: hidden;">
                                    </div>


                                    <!-- Logo upload -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group {{ $errors->first('file', 'has-error') }}">
                                            <label for="cover_img">{{ trans('general.community.logo')}}</label>
                                            <div class="fancy-file-upload fancy-file-info">
                                                <i class="fa fa-picture-o"></i>
                                                <input type="file" class="form-control" id="logo_img" name="logo" onchange="jQuery(this).next('input').val(this.value);"/>
                                                <input type="text" class="form-control" id="logo_shadow_input" placeholder="{{ trans('general.entries.file_placeholder')}}" readonly=""/>
                                                <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                                            </div>
                                            <p class='too_large_logo smooth_font' style="display:none;font-size:30px">{{ trans('general.entries.max_file_size')}}</p>

                                            <p>{{ trans('general.uploads.logo_tip')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-md-offset-1 col-xs-12 margin-bottom-10" style="background-color:#fff;height:100px">
                                        <div class="col-md-4 col-md-offset-4" style="position:absolute;top:35%;">
                                            <img src="{{ $whitelabel_group->getLogo() }}" style="object-fit:cover;overflow: hidden;">
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- IMAGES TAB -->


                            <!-- ADVANCED TAB -->
                            <div class="tab-pane fade" id="advanced">

                                <!-- Theme -->
                                <div class="form-group">
                                    <label for="theme">
                                        {{ trans('general.community.choose_theme')}}
                                    </label>
                                    {{ Form::select('theme', $themes, $community->theme, array('class'=>'select', 'style'=>'width:100%')) }}
                                    {!! $errors->first('theme', '<span class="help-block">:message</span>') !!}
                                </div> <!-- Theme -->

                                <fieldset class="nomargin">
                                    <legend>
                                        {{ trans('general.community.slackbot_integration')}}

                                    </legend>
                                    <!-- Slack endpoint -->


                                    <p>{{ trans('general.community.slack_optional')}}</p>
                                    <div class="form-group{{ $errors->first('slack_botname', ' has-error') }}">
                                        <label for="slack_endpoint">{{ trans('general.community.slack_webhook')}}
                                            <button type="button" class="" data-toggle="modal" data-target="#slackEndPoint"><i style='color:#5bc0de;' class='fa fa-info-circle'></i></button>
                                        </label>
                                        <input type="text" name="slack_endpoint" class="form-control" placeholder="https://hooks.slack.com/services/xxxxxxxxxxxxxxxxxxxxx"
                                               value="{{ Input::old('slack_endpoint', $community->slack_endpoint) }}">
                                        {!! $errors->first('slack_endpoint', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- Slack endpoint -->

                                    <!-- Slack botname -->
                                    <div class="form-group{{ $errors->first('slack_botname', ' has-error') }}">
                                        <label for="slack_botname">{{ trans('general.community.slack_bot_name')}}</label>
                                        <input type="text" name="slack_botname" class="form-control" placeholder="" value="{{ Input::old('slack_botname', $community->slack_botname) }}">
                                        {!! $errors->first('slack_botname', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- Slack botname -->

                                    <!-- Slack channel -->
                                    <div class="form-group{{ $errors->first('slack_channel', ' has-error') }}">
                                        <label for="slack_channel">{{ trans('general.community.slack_channel')}}</label>
                                        <input type="text" name="slack_channel" class="form-control" placeholder="" value="{{ Input::old('slack_channel', $community->slack_channel) }}">
                                        {!! $errors->first('slack_channel', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- Slack channel -->
                                </fieldset>


                                <!-- Slack slash command settings -->
                                <fieldset class="nomargin">
                                    <legend>
                                        {{ trans('general.community.slackslash_integration')}}
                                        <button type="button" class="" data-toggle="modal" data-target="#slackbotModal"><i class='fa fa-info-circle'></i></button>
                                    </legend>


                                    <!-- Want token -->

                                    <p>{{ trans('general.community.slackslash_info')}}</p>
                                    <div class="form-group{{ $errors->first('slack_slash_want_token', ' has-error') }}">
                                        <label for="slack_slash_want_token">{{ trans('general.community.slack_slash_want_token')}}
                                            <input type="text" name="slack_slash_want_token" class="form-control" value="{{ Input::old('slack_slash_want_token', $community->slack_slash_want_token) }}">
                                        {!! $errors->first('slack_slash_want_token', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- Slack endpoint -->

                                    <!-- Slack botname -->
                                    <div class="form-group{{ $errors->first('slack_slash_have_token', ' has-error') }}">
                                        <label for="slack_slash_have_token">{{ trans('general.community.slack_slash_have_token')}}</label>
                                        <input type="text" name="slack_slash_have_token" class="form-control" placeholder="" value="{{ Input::old('slack_slash_have_token', $community->slack_slash_have_token) }}">
                                        {!! $errors->first('slack_slash_have_token', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- Slack botname -->

                                    <!-- Slack channel -->
                                    <div class="form-group{{ $errors->first('slack_slash_members_token', ' has-error') }}">
                                        <label for="slack_channel">{{ trans('general.community.slack_slash_members_token')}}</label>
                                        <input type="text" name="slack_slash_members_token" class="form-control" placeholder="" value="{{ Input::old('slack_slash_members_token', $community->slack_slash_members_token) }}">
                                        {!! $errors->first('slack_slash_members_token', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- Slack channel -->
                                </fieldset>


                                <fieldset class="nomargin">
                                    <legend>{{ trans('general.analytics')}}</legend>
                                    <!-- Google analytics ID -->
                                    <div class="form-group{{ $errors->first('ga', ' has-error') }}">
                                        <label for="slack_channel" class="sr-only">{{ trans('general.analytics_id') }}</label>

                                        <input type="text" name="ga" class="form-control" placeholder="{{ trans('general.community.for_example')}}" value="{{ Input::old('ga', $community->ga) }}">
                                        {!! $errors->first('ga', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- Google analytics ID -->
                                </fieldset>

                                <fieldset class="nomargin">
                                    <legend>{{ trans('general.wrld3d')}}</legend>
                                    <p>{{ trans('general.community.wrld3d_info')}}</p>
                                    <!-- WRLD3D API KEY -->
                                    <div class="form-group{{ $errors->first('wrld3d', ' has-error') }}">
                                        <label for="wrld3d" class="sr-only">{{ trans('general.wrld3d_api') }}</label>

                                        <input type="text" name="wrld3d" class="form-control" value="{{ Input::old('wrld3d', $community->wrld3d) }}">
                                        {!! $errors->first('wrld3d', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- WRLD3D API KEY -->
                                </fieldset>
                            </div> <!-- ADVANCED TAB -->

                        </div> <!-- tab-content -->

                        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                            <button class="btn btn-colored">{{ trans('general.community.save') }}</button>
                        </div>
                    </form>
                </div> <!-- col-10 -->
            </div> <!-- row -->
        </div> <!-- edit_wrapper -->
    </section> <!-- container -->
    <!-- / -->


    <!-- Modals -->

    <div id="infoBarModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Hide Information Bar?</h4>
                </div>
                <div class="modal-body">
                    <img src="/assets/img/info_bar.png" width="100%" alt="home page information bar featuring privacy level of share, number of members and exchange types"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div id="privacyLevelModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Choosing a Privacy Level</h4>
                </div>
                <div class="modal-body">
                    <ul>
                        <li><strong>{{ trans('general.community.open.type') }}</strong> - {{ trans('general.community.open.desc') }}</li>
                        <li><strong>{{ trans('general.community.closed.type') }}</strong> - {{ trans('general.community.closed.desc') }}</li>
                    <!-- <li><strong>{{ trans('general.community.secret.type') }}</strong> - {{ trans('general.community.secret.desc') }}</li> -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div id="slackbotModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('general.community.slackbot_integration')}}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('general.community.slack_info.p1')}}</p>
                    <p>{{ trans('general.community.slack_info.p2')}}</p>
                    <p>{{ trans('general.community.slack_info.p3')}}</p>
                    <p>{{ trans('general.community.slack_info.p4')}}</p>
                    <p>{{ trans('general.community.slack_info.p5')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('general.close') }}</button>
                </div>
            </div>
        </div>
    </div>


    <div id="slackEndPoint" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('general.community.slack_webhook')}}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('general.community.incoming_hook')}} <a target="_blank" href="https://api.slack.com/incoming-webhooks">{{ trans('general.community.slack_setting_up_webhook')}}</a>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {

            $("#cover_img").change(function () {
                var maxSize = $('#MAX_FILE_SIZE').val();
                $('#cover_shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));

                if ($("#cover_img")[0].files[0].size > maxSize) {
                    $("#cover_shadow_input").val("");
                    $('p.too_large_cover').show().addClass("error_message").fadeOut(5000, "swing");
                }
            });

            $("#logo_img").change(function () {
                var maxSize = $('#MAX_FILE_SIZE').val();
                $('#logo_shadow_input').val($(this).val().replace("C:\\fakepath\\", ""));

                if ($("#logo_img")[0].files[0].size > maxSize) {
                    $("#logo_shadow_input").val("");
                    $('p.too_large_logo').show().addClass("error_message").fadeOut(5000, "swing");
                }
            });

            $(document).on("click", "#select_all", function (e) {
                $('.exchanges').prop('checked', $(this).prop("checked"));
            });

            $(document).on("click", ".exchanges", function (e) {
                $('#select_all').prop('checked', false);
            });
        });

    </script>
@stop
