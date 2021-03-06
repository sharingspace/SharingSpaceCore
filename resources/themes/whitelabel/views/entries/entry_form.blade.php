<!-- entry form -->
<form method="post"
      @if($entry->getKey())
      action="{{ route('entry.edit.save', $entry->getKey()) }}"
      @else
      action="{{ route('entry.create.ajax.save') }}"
      @endif
      enctype="multipart/form-data" autocomplete="off" class="margin-left-10 margin-right-10" id="entry_form">
    {!! csrf_field() !!}
    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value={{ trans('general.entries.max_size')}} />
    <input type="hidden" name="upload_key" id="upload_key" value=""/>
    <input type="hidden" id="rotation" name="rotation" value=''>
    <input type="hidden" id="entryId" name="entryId" value=''>
    <input type="hidden" id="entry_image_delete" name="entry_image_delete" value=''>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="form-group" style="margin-bottom: 5px;">
                <fieldset class="margin-bottom-10">

                    <legend class="sr-only">{{ trans('general.entries.edit.exchange_by') }}</legend>
                    <div class="exchange_types">
                        <!-- checkboxes for exchange types -->
                        <div class="checkbox">
                            @if (isset($selected_exchanges))
                                @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                                    <div class="col-sm-12 col-xs-6 pull-left margin-bottom-10">
                                        <label class="checkbox col-md-12 pull-left margin-bottom-10">
                                            @if (isset($selected_exchanges[$exchange_types->id]))
                                                {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, true, ['class' => 'exchanges']) }}
                                            @else
                                                {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, false, ['class' => 'exchanges']) }}
                                            @endif
                                            <i></i> {{ $exchange_types->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
                                    <div class="col-sm-12 col-xs-6 pull-left margin-bottom-10">
                                        <label class="checkbox col-md-12 pull-left margin-bottom-10">
                                            {{ Form::checkbox('exchange_types['.$exchange_types->id.']', $exchange_types->id, true, ['class' => 'exchanges']) }}
                                            <i></i> {{ $exchange_types->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                            <div class="col-xs-12 pull-left margin-bottom-10">
                                <label class="checkbox col-md-12 pull-left margin-bottom-10">
                                    {{ Form::checkbox('select_all', 10, false, ['id' => 'select_all']) }}
                                    <i></i> {{trans('general.community.all_exchanges')}}
                                </label>
                            </div>
                        </div>
                    </div> <!-- exchange_types -->
                </fieldset>
            </div> <!-- form-group -->
        </div> <!-- col-md-3 -->

        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 margin-bottom-10">
                            <select class="form-control" name="post_type" id="post_type">
                                @foreach($post_types as $key=>$val)
                                    @if ($entry->post_type == $key)
                                        <option value="{{ $key }}" selected>{{ $val }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div> <!-- col 3 -->
                        <div class="col-md-3 margin-bottom-10">
                            <!-- stepper -->
                            <input type="text" value="{{ old('qty', $entry->qty ?: 1) }}" min="1" max="1000" class="form-control stepper" id="qty" name="qty">
                        </div> <!-- col 3 -->
                        <div class="col-md-6 margin-bottom-8">
                            <!-- Name -->
                            <label class="input">
                                <input type="text" name="title" id="title" required='' class="form-control" placeholder="{{ trans('general.entry')}}" value="{{ old('title', $entry->title) }}" autofocus>
                            </label>
                        </div> <!-- col 6 -->

                        <div class="col-xs-12">
                            <!-- File upload   -->
                            <div class="fancy-file-upload fancy-file-info">
                                <i class="fa fa-picture-o"></i>
                                <input id="entry_image" type="file" class="form-control" accept="image/jpg,image/png,image/jpeg,image/gif" name="file" onchange="jQuery(this).next('input').val(this.value);"/>
                                <input id="entry_image_shadow" type="text" class="form-control" placeholder="{{ trans('general.entries.file_placeholder')}}" readonly=""/>
                                <span class="button btn-colored">{{ trans('general.uploads.choose_file') }}</span>
                            </div> <!-- fancy -->
                            <p class="too_large smooth_font margin-bottom-0" style="display:none;font-size:30px">{{ trans('general.entries.max_file_size')}}</p>
                        </div> <!-- col 12-->
                    </div> <!-- row-->
                </div> <!-- col 12-->

                <div id="dialog-confirm" title="Delete image?">
                    <p>
                        <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>
                        <span>{{ trans('general.entries.edit.delete_image') }}</span>
                    </p>
                </div>

                <div class="pull-right col-xs-12">
                    <div id="entry_image_container">
                        <div id="entry_image_box" @if (isset($image)) style="background-image: url('/assets/uploads/entries/{{ $entry->getKey() }}/{{ $image }}');" @endif> <!-- contains entry image -->
                        </div>
                        <div class="row">
                            <div class="col-xs-12 image_controls">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <i class="fa fa-2x fa-rotate-right" aria-hidden="true" id="rotate_image" title="{{ trans('general.entries.edit.rotate_image') }}"></i>
                                    </div>
                                    <div class="col-xs-12">
                                        <i class="fa fa-2x fa-times" aria-hidden="true" id="delete_image" title="{{ trans('general.entries.edit.remove_image') }}" onclick="deleteImgDialog('entry')"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- col 12-->

                <div class="col-xs-4 col-xs-offset-4">
                    <div id="progressbar">
                        <!-- progress bar -->
                    </div>
                </div>

                <div class="col-xs-12">
                    <!-- Description -->
                    <label class="input">
                        ({{trans('general.markdown')}}
                        <a href="https://anyshare.freshdesk.com/support/solutions/articles/17000035463-using-markdown" target="_blank">
                            <i class='fa fa-info-circle'></i>
                        </a> )
                        <textarea name="description" rows="5" class="form-control" data-maxlength="200" id="description" data-info="textarea-words-info"
                                  placeholder="{{ trans('general.entries.description_placeholder')}}">{{ old('description', $entry->description) }}</textarea>
                    </label>
                </div> <!-- col 12 -->

                <div class="col-xs-12">
                    <!-- Tags -->
                    <label class="input">
                        <input data-role="tagsinput" type="text" name="tags" id="tags" class="col-md-12 form-control" placeholder="{{ trans('general.entries.tag_placeholder')}}" value="{{ old('tags', $entry->tags) }}">
                    </label>
                </div> <!-- col 12 -->

                <div class="col-xs-12">
                    <!-- Location -->
                    <label class="control-label sr-only" for="location">{{ trans('general.location') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="location" name="location" placeholder="{{ trans('general.near')}}" aria-describedby="basic-addon2" value="{{{ old('location', $entry->location) }}}">
                        <div class="input-group-addon" id="basic-addon2">
                            <i class="fa fa-location-arrow" id="geolocate"></i>
                        </div>
                    </div> <!-- input-group -->
                </div>

                <div class="col-xs-12">
                    <!-- WRLD 3D Map -->
                    @include('partials.map')
                </div>

                <div class="col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <label class="checkbox pull-left" for="visible_checkbox">
                                {{ Form::checkbox('private', 1, old('visible') ? old('visible') === 0 : $entry->visible === 0, array('id'=>'visible_checkbox')) }}
                                <i></i> {{ trans('general.entries.not_visible')}}
                            </label>
                        </div>
                        <div class="col-sm-6 col-xs-12 ">
                            <label class="checkbox pull-left" for="completed">
                                @if($entry->getKey())
                                    {{ Form::checkbox('completed', 1, old('completed', $entry->completed_at), array('id'=>'completed')) }}
                                    <i></i> {{ trans('general.entries.mark_completed')}}
                                @endif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12 ">
                    
                    <button class="btn btn-colored pull-right" @if ($entry->getKey()) id="ajaxSubmit" name="ajaxSubmit" value="ajaxSubmit" @endif onclick="mixpanel.track('New Entry',{'user_id': '<?=Auth::user()->id?>', 'title': $('#title').val()});">
                        {{ trans('general.entries.save_entry') }}
                        
                    </button>
                    <a class="btn btn-light-colored pull-right" id="cancel_button" href="">{{ trans('general.cancel') }}</a>
                </div> <!-- col 2 -->
            </div> <!-- row -->

            <input type="hidden" name="latitude" id="location_lat" value="{{ $entry->latitude }}">
            <input type="hidden" name="longitude" id="location_lng" value="{{ $entry->longitude }}">
            <input type="hidden" name="indoors_id" id="indoors_id" value="{{ isset($entry->indoors) ? $entry->indoors->get('id') : '' }}">
            <input type="hidden" name="indoors_floor" id="indoors_floor" value="{{ isset($entry->indoors) ? $entry->indoors->get('floor') : '' }}">

        </div> <!-- col 9 -->
    </div>  <!-- row -->
</form>