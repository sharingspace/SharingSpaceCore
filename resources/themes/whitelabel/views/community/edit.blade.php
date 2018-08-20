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

                <form method="post" action="{{ route('_edit_share') }}" enctype="multipart/form-data" id="edit_share" role="form">
                {!! csrf_field() !!}

                    <!-- Entry -->
                    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
                        <ul class="nav nav-tabs nav-top-border">
                            <li class="active"><a href="#info" data-toggle="tab" aria-expanded="true"> {{trans('general.community.basic')}} </a></li>
                            <li><a href="#hub_images" data-toggle="tab">{{trans('general.community.images')}}</a></li>
                            <li><a href="#advanced" data-toggle="tab">{{trans('general.community.advanced')}}</a></li>
                            <li><a href="#roles" data-toggle="tab" aria-expanded="false">{{trans('general.role.roles')}}</a></li>
                        </ul>

                        <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="6144000"/>
                        <input type="hidden" id="cover_image_delete" name="cover_image_delete" value=''>
                        <input type="hidden" id="logo_image_delete" name="logo_image_delete" value=''>

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
                                            <label class="input">{{trans('general.community.description')}} ({{trans('general.markdown')}} <a target="_blank" href="https://anyshare.freshdesk.com/support/solutions/articles/17000035463-using-markdown"><i class='fa fa-info-circle'></i></a> )
                                                <textarea name="about" rows="5" class="form-control" data-maxlength="200" id="about" data-info="textarea-words-info" placeholder="{{trans('general.community.detailed_description')}}">
                                                    {{ Input::old('about', $community->about) }}
                                                </textarea>
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

                                        {{-- <label class="margin-top-15" for="info_bar" style="display: block;">
                                        Hide home page information bar?
                                        <input name="show_info_bar" type="checkbox" value="0"
                                        @if (!$whitelabel_group->show_info_bar)
                                                            checked
                                        @endif
                                                >
                                                <button type="button" class="" data-toggle="modal" data-target="#infoBarModal">
                                                  <i style='color:#5bc0de;' class='fa fa-info-circle'></i>
                                                </button>
                                              </label>  --}}
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
                                    <div class="col-xs-12">
                                        <!-- Cover upload -->
                                        <div class="form-group {{ $errors->first('file', 'has-error') }}">
                                            <label for="cover_image">{{ trans('general.uploads.cover_image') }}</label>
                                            <div class="fancy-file-upload fancy-file-info">
                                                <i class="fa fa-picture-o"></i>
                                                <input type="file" class="form-control" id="cover_image" name="cover_img" onchange="jQuery(this).next('input').val(this.value);"/>
                                                <input type="text" class="form-control" id="cover_image_shadow" placeholder="{{ trans('general.entries.file_placeholder')}}" readonly=""/>
                                                <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                                            </div>
                                            <p class='too_large_cover smooth_font' style="display:none;font-size:30px">{{ trans('general.entries.max_file_size')}}</p>
                                            <p>{{ trans('general.uploads.banner_tip')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div id="cover_image_container">
                                            <div id="cover_image_box"
                                                 @if ($whitelabel_group->getCover())
                                                 style="background-image: url({{ $whitelabel_group->getCover() }});"
                                                    @endif
                                            > <!-- contains background image -->
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 image_controls">
                                                    <i class="fa fa-2x fa-times" aria-hidden="true" id="cover_image_delete" title="{{ trans('general.entries.edit.remove_image') }}" onclick="deleteImgDialog('cover')"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Logo upload -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group {{ $errors->first('file', 'has-error') }}">
                                            <label for="logo_image">{{ trans('general.community.logo')}}</label>
                                            <div class="fancy-file-upload fancy-file-info">
                                                <i class="fa fa-picture-o"></i>
                                                <input type="file" class="form-control" id="logo_image" name="logo" onchange="jQuery(this).next('input').val(this.value);"/>
                                                <input type="text" class="form-control" id="logo_image_shadow" placeholder="{{ trans('general.entries.file_placeholder')}}" readonly=""/>
                                                <span class="button">{{ trans('general.uploads.choose_file') }}</span>
                                            </div>
                                            <p class='too_large_logo smooth_font' style="display:none;font-size:30px">{{ trans('general.entries.max_file_size')}}</p>

                                            <p>{{ trans('general.uploads.logo_tip')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-md-offset-1 col-xs-12 margin-bottom-10">
                                        <div id="logo_image_container">
                                            <div id="logo_image_box"
                                                 @if ($whitelabel_group->getLogo())
                                                 style="background-image: url({{ $whitelabel_group->getLogo() }});"
                                                    @endif
                                            > <!-- contains logo image -->
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 image_controls">
                                                    <i class="fa fa-2x fa-times" aria-hidden="true" id="logo_image_delete" title="{{ trans('general.entries.edit.remove_image') }}" onclick="deleteImgDialog('logo')"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- IMAGES TAB -->

                            <!-- ADVANCED TAB -->
                            <div class="tab tab-pane fade" id="advanced">

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
                                    <legend>{{ trans('general.wrld3d.label')}}</legend>
                                    <p>{{ trans('general.community.wrld3d_info')}}</p>
                                    <!-- DEV TOKEN -->
                                    <div class="form-group{{ $errors->first('wrld3d.dev_token', ' has-error') }}">
                                        <label for="wrld3d[dev_token]">{{ trans('general.wrld3d.dev_token') }}</label>

                                        <input type="text" name="wrld3d[dev_token]" class="form-control" value="{{ Input::old('wrld3d.dev_token', $community->wrld3d ? $community->wrld3d->get('dev_token') : '') }}">
                                        {!! $errors->first('wrld3d.dev_token', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- DEV TOKEN -->
                                    <!-- WRLD3D API KEY -->
                                    <div class="form-group{{ $errors->first('wrld3d.api_key', ' has-error') }}">
                                        <label for="wrld3d[api_key]">{{ trans('general.wrld3d.api_key') }}</label>

                                        <select type="text" name="wrld3d[api_key]" class="form-control"
                                                value="{{ Input::old('wrld3d.api_key', $community->wrld3d ? $community->wrld3d->get('api_key') : '') }}"
                                                @if (empty($community->wrld3d) || empty($community->wrld3d->get('dev_token'))) disabled @endif>
                                            <option value="">{{ trans('general.wrld3d.api_key_select') }}</option>
                                            @foreach ($poisets as $poiset)
                                                <option value="{{ $poiset->get('code') }}" @if (!empty($community->wrld3d->get('poiset')) && $community->wrld3d->get('poiset') === intval($poiset->get('id'))) selected @endif>
                                                    {{ $poiset->get('name') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('wrld3d.api_key', '<span class="help-block">:message</span>') !!}
                                    </div> <!-- WRLD3D API KEY -->
                                    @if (!empty($community->wrld3d) && $community->wrld3d->get('poiset'))
                                        <div class="form-group">
                                            <a tabindex="-1" href="{{ route('_update_share_pois') }}" class="link">Update POIs of entries</a>
                                        </div>
                                    @endif
                                </fieldset>
                            </div> <!-- ADVANCED TAB -->

                            <!-- ROLES TAB -->
                            <div class="tab tab-pane fade" id="roles">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="col-xs-8">
                                            {!! Form::hidden('role_id',null,['id' => 'role-id']) !!}
                                                                        
                                            <h2 class="margin-bottom-0  size-24 text-center">
                                                {!!trans('general.role.create') !!}
                                            </h2>

                                            <section>
                                                <div class="row">
                                                    <!-- Name -->
                                                    <div class="form-group {{ $errors->first('rolename', ' has-error') }}">
                                                        <label for="name" class="input">{{trans('general.role.name')}} *
                                                            <input id="name" type="text" name="rolename" class="form-control" placeholder="{{trans('general.role.name_placeholder')}}" value="">
                                                            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">   
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading"> 
                                                            <label class="checkbox">
                                                            {{ Form::checkbox('checkall', '', false, ['class' => 'exchanges', 'id' => 'permissions']) }}
                                                            <i></i>Permissions
                                                            </label>
                                                        </div>
                                                        <div class="panel-body">

                                                        @foreach($permissions as  $permission)
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="checkbox col-md-12 margin-bottom-10">
                                                                        {{ Form::checkbox('permissions['.$permission->id.']', $permission->id, 
                                                                        isset($role_permissions) && in_array($permission->id,$role_permissions) ? true : false, ['class' => 'exchanges checkall']) }}
                                                                            <i></i> {{ $permission->display_name }}
                                                                    </label>
                                                                </div>
                                                            </div>        
                                                        @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>

                                        <div class="col-xs-4">
                                            <h2 class="margin-bottom-0  size-24 text-center">{{ trans('general.role.roles') }}</h2>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
                                                <div class="table-responsive">
                                                    <table class="table table-condensed" id="members">
                                                        <tbody>
                                                            <tr>
                                                              <th class="col-md-3">{{ trans('general.role.name') }}</th>
                                                              <th class="col-md-2">{{ trans('general.role.permission') }}</th>
                                                              <th class="col-md-2">{{ trans('general.action') }}</th>
                                                            </tr>
                                                        @foreach ($roles as $role)
                                                            <tr>
                                                                <td role-id="{{$role->id}}" class="role col-md-3"> <a  href="#">{{ $role->name }}</a></td>
                                                                <td class="col-md-2"> {{ $role->permissions()->count() }}</td>
                                                                <td class="col-md-1">
                                                                    <a href="{{ route('admin.role.delete', $role->id) }}">
                                                                  {{ trans('general.delete') }}
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div> <!-- table responsive -->
                                            </div> <!-- col-lg-12 -->
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- ROLES TAB -->

                        </div> <!-- tab-content -->

                        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                            <button class="btn btn-colored">{{ trans('general.community.save') }}</button>
                        </div>
                    </div> <!-- col-10 -->
                </form>
            </div> <!-- row -->
        </div> <!-- edit_wrapper -->
        @include('./progress')

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

    <div id="dialog-confirm" title="Delete image?">
        <p><i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i><span>{{ trans('general.entries.edit.delete_image') }}</span></p>
    </div>
@stop

@section('custom_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
    <script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
    <script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>

    <script type="text/javascript">
        var reader = new FileReader(); // instance of the FileReader

        $(document).ready(function () {

            $('#permissions').change(function() {
                if($(this).is(':checked')) {
                    $('.checkall').prop("checked", true);
                }else {
                    $('.checkall').prop("checked", false);
                }
            });

            $('#members').bootstrapTable({
                classes: 'table table-responsive table-no-bordered',
                undefinedText: '',
                iconsPrefix: 'fa',
                showRefresh: false,
                search: true,
                pageSize: 20,
                pagination: true,
                sortable: true,
                mobileResponsive: true,
                formatShowingRows: function (pageFrom, pageTo, totalRows) {
                    return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' members';
                },
                icons: {
                    paginationSwitchDown: 'fa-caret-square-o-down',
                    paginationSwitchUp: 'fa-caret-square-o-up',
                    columns: 'fa-columns',
                    refresh: 'fa-refresh'
                }
            });


            if ($('#cover_image_box').css('background-image') != 'none') {
                $('#cover_image_container').show();
                console.log($('#cover_image_box').css('background-image'));
            }
            if ($('#logo_image_box').css('background-image') != 'none') {
                $('#logo_image_container').show();
                console.log($('#logo_image_box').css('background-image'));
            }

            $(document).on("click", "#select_all", function (e) {
                $('.exchanges').prop('checked', $(this).prop("checked"));
            });

            $(document).on("click", ".exchanges", function (e) {
                $('#select_all').prop('checked', false);
            });
        });
        
        $(document).on("click", ".role", function (e) {
            var id = $(this).attr('role-id');
            $('#role-id').val(id);
            $.ajax({
                url: '/admin/role/get-role-data/'+id,
                method: 'GET',
                dataType: "json",
                success: function (result) {
                    $('#name').val(result.model.name);
                    $.each($('.checkall'), function(key, val) {

                        $(val).prop('checked', false);
                        
                        $.each(result.role_permissions, function(key, value) {
                            if($(val).val() == value) {
                                $(val).prop('checked', true);
                            }
                        });
                    });
                }
              });
        });

    </script>
    <script src="{{ Helper::cdn('js/entry_utils.js')}}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@stop
