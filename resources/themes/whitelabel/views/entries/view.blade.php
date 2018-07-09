@extends('layouts/master')

{{-- Page title --}}
@section('title')
    {{ trans('general.entries.view') }} ::
    @parent
@stop

{{-- Page content --}}
@section('content')

    <!-- -->
    <section>
        <div id="entry_view" class="container padding-top-0">
            <div class="row margin-bottom-20">
                @if(isset($images) && (count($images) > 0) && $images[0]->filename)
                    <div class="col-md-4 col-sm-5 col-xs-12 margin-top-20">
                        <div id="entry_image_box">
                            <img id="entryImage" src="{{ Helper::cdn('uploads/entries/'.$entry->id.'/'.$images[0]->filename) }}">
                        </div>
                    </div> <!-- col-md-4 -->

                    <div class="col-md-8 col-sm-7 col-xs-12 margin-top-20">
                        @else
                            <div class="col-xs-12 margin-top-20">
                                @endif
                                <h1 class="size-18 margin-bottom-10"><span class="sr-only">{{ trans('general.entries.view') }},</span> {{ strtoupper($entry->post_type) }}: {{ $entry->title }}</h1>

                                @if($entry->author->getDisplayName())
                                    <div class="margin-bottom-3">
                                        <strong class="primaryText">{{ trans('general.entries.by') }}:</strong> {{$entry->author->getDisplayName()}}
                                        @if ($entry->author->getCustomLabelInCommunity($whitelabel_group))
                                            <span class="label label-primary">{{ $entry->author->getCustomLabelInCommunity($whitelabel_group) }}</span>
                                        @endif
                                    </div>
                                @endif

                                @if (count($entry->exchangeTypes) > 0)
                                    <div class="margin-bottom-3">
                                        <?php  $exchanges = []; ?>
                                        @for ($i = 0; $i < count($entry->exchangeTypes); $i++)
                                            <?php array_push($exchanges, strtolower($entry->exchangeTypes[$i]->name)); ?>
                                        @endfor
                                        <strong class="primaryText">{{ trans('general.type') }}:</strong> {{implode(', ', $exchanges)}}
                                    </div>
                                @endif

                                @if($entry->qty)
                                    <div class="margin-bottom-3">
                                        <strong class="primaryText">{{ trans('general.entries.qty') }}:</strong> {{$entry->qty}}
                                    </div>
                                @endif

                                @if($entry->location)
                                    <div class="margin-bottom-3">
                                        <strong class="primaryText">{{ trans('general.location') }}:</strong> {{ $entry->location }}
                                    </div>
                                @endif

                                <div class="margin-bottom-3">
                                    <strong class="primaryText">{{ trans('general.entries.visibility') }}:</strong>

                                    @if ($entry->completed_at)
                                        {{ trans('general.entries.not_visible') }} ({{ trans('general.entries.completed') }})
                                    @else
                                        @if($entry->visible)
                                            {{ trans('general.entries.visible') }}
                                        @else
                                            {{ trans('general.entries.not_visible') }}
                                        @endif
                                    @endif
                                </div>

                                @if($entry->description)
                                    <div class="margin-bottom-3">
                                        <strong class="primaryText">{{ trans('general.entries.description') }}:</strong> {!! Markdown::convertToHtml($entry->description) !!}
                                    </div>
                                @endif

                                @if($entry->tags)
                                    <div class="margin-bottom-3">
                                        <strong class="primaryText">{{ trans('general.keywords') }}:</strong> {{ $entry->tags }}
                                    </div>
                                @endif

                            <!-- if user is admin or owner -->
                                @can('update-entry', $entry)
                                    <div class="margin-bottom-3">
                                        @if($entry->created_by == Auth::user()->id || Permission::checkPermission('edit-any-entry-permission'))
                                            <div class="margin-top-10 listing-actions">
                                                {{ Form::open(array('route'=>array('entry.delete.save',$entry->id))) }}
                                                {{ Form::token()}}
                                                <a href="{{ route('entry.edit.form', $entry->id) }}" class="btn btn-xs btn-light-colored tooltipEnable" data-container="body" data-toggle="tooltip" data-placement="bottom"
                                                   title="Edit This {{ strtoupper($entry->post_type) }}" data-mm-track-label="Edit from Tile View">
                                                    <i class="fa fa-pencil"></i> {{trans('general.entries.edit_entry')}}</a>
                                                @if($entry->created_by == Auth::user()->id || Permission::checkPermission('delete-any-entry-permission'))     
                                                    <button type="submit" class="btn btn-xs btn-dark-colored margin-left-5"><i class='fa fa-trash'></i> {{trans('general.entries.delete')}}</button>
                                                @endif

                                                {{ Form::close() }}
                                            </div> <!-- listing-actions -->
                                        @endif
                                    </div> <!-- if user is admin or owner -->
                                @endcan
                            </div> <!-- col-8/12 -->
                    </div> <!-- row -->

                    @if ($entry->hasGeolocation())
                        <div class="margin-bottom-10 margin-top-4">
                            @include('partials.map')
                        </div>
                    @endif

                <!-- Nav tabs -->
                    @can('make-offer', [$entry, $whitelabel_group])
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active">
                                <a href="#make_offer" role="tab" data-toggle="tab">
                                    {{ trans('general.entries.make_offer') }}
                                </a>
                            </li>

                            @if ($images && count($images) > 1)
                                <li>
                                    <a href="#view_images_tab" role="tab" data-toggle="tab">{{ trans('general.entries.more_images') }}</a>
                                </li>
                            @endif 

                        <!-- <li><a id="view_map_tab" href="#view_map" role="tab" data-toggle="tab">View Map</a></li> -->
                        <!-- <li>
        <a id="view_comment_tab" href="#comments" role="tab" data-toggle="tab">{{ trans('general.entries.comments_tab') }}</a>
      </li> -->
                        </ul> <!-- nav-tabs -->
                @endcan

                <!-- Tab panes -->
                    <div class="tab-content">
                        @if (Auth::check())
                            @if ($entry->expired)
                                <p>{{ trans('general.entries.sorry_expired') }}</p>
                            @elseif ($entry->completed_at!='')
                                <p>{{ trans('general.entries.completed_interest') }} <a href="{{ route('entry.create.form') }}">{{ trans('general.entries.list') }}</a></p>
                            @else
                                @can('make-offer', [$entry, $whitelabel_group])
                                    <div class="tab-pane active margin-top-6" id="make_offer">
                                        <form id="offerForm">
                                            <p class='margin-bottom-6 pull-right size-11'><i class='fa fa-asterisk'></i> {{ trans('general.entries.only_owner') }}</p>

                                            <!--MAKE AN OFFER-->
                                            {!! csrf_field() !!}
                                            <div class="margin-bottom-8 {{ $errors->first('title', ' has-error') }}">
                                                <!-- Subject -->
                                                <label class="input">
                                                    <input type="text" name="subject" class="form-control" placeholder="Subject &#133;" autofocus>
                                                </label>
                                            </div>

                                            <div class="form-group clearfix">
                                                <textarea rows="5" name="message" id="message" class="form-control" placeholder="{{ trans('general.entries.subject_placeholder') }}"></textarea>
                                            </div>

                                            <p class='margin-bottom-6 pull-left'>{{ trans('general.entries.i_would_like') }}</p>
                                            <div class="form-group  padding-bottom-20 {{ $errors->first('message', 'has-error') }}">
                                                <ul class="exchange_types">
                                                    @if (count($entry->exchangeTypes) > 0)
                                                        @for ($i = 0; $i < count($entry->exchangeTypes); $i++)
                                                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                                <input type="checkbox" name="exchange_types[]" value="{{ strtolower($entry->exchangeTypes[$i]->name) }}" id="{{strtolower($entry->exchangeTypes[$i]->name) }}">
                                                                {{ $entry->exchangeTypes[$i]->name }}
                                                            </div> <!-- col-sm-3 -->
                                                        @endfor
                                                    @endif
                                                </ul> <!-- exchange_types -->
                                            </div> <!-- form-group -->

                                            <div class="row hidden">
                                                <div class="col-md-9 col-sm-12 col-xs-12 form-group" id="amountbox">
                                                    <div class="col-md-3">
                                                        <p class="help-block">{{ trans('general.entries.offer_amount') }}</p>
                                                    </div>

                                                    <div class="input-group col-md-3">
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-usd"></span>
                  </span>
                                                        <input type="text" id="amount" name="amount" class="form-control" value="{{{ Input::old('amount') }}}">
                                                    </div>
                                                </div>  <!-- col-md-9 -->
                                            </div> <!-- row -->

                                            <div class="form-group pull-right">
                                                <button type="submit" class="btn btn-warning pull-right" id="messageSubmit">{{ trans('general.entries.make_offer') }}</button>
                                            </div>  <!-- col-md-3 -->
                                        </form>
                                    </div> <!-- tab-pane -->
                                @endcan

                                @can('join-community', $whitelabel_group)
                                    <p><strong>{{ trans('general.user.join_to_send_message') }}.</strong></p>
                                    <p>
                                        <a class="btn btn-colored btn-sm" href=
                                        @if ($whitelabel_group->group_type == 'O')
                                                "{{ route('join-community') }}">
                                            @else
                                                "{{ route('community.request-access.form') }}">
                                            @endif
                                            {{ trans('general.register.join_share') }}</a>
                                    </p>
                                @endcan <!-- if make-offer -->
                            @endif
                        @else
                            <p><strong>{{ trans('general.user.login_to_send_message') }}.</strong></p>
                            <p><a class="btn btn-colored" href="{{ route('login') }}">{{ trans('general.nav.login') }}</a></p>
                    @endif <!-- logged in -->

                    <!-- currently we do not show existing offers on an entry <p>find home for this {{ trans('general.entries.no_offers') }}</p>  -->

                        <div class="tab-pane" id="view_images_tab">
                            @if($images)
                                @foreach ($images as $image)
                                    <div class="col-xs-3 col-sm-3 col-md-3" style="margin-top:20px;object-fit:contain;">
                                        <img src="{{ Helper::cdn('uploads/entries/'.$entry->id.'/'.$image->filename) }}" height="250" width="250" border="1">
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="tab-pane" id="view_map">
                            <!--MAP-->
                            @if (($entry->latitude!='') && ($entry->longitude!=''))
                                <div id="map" style="height: 250px;"></div>
                            @else
                                <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:20px;">
                                    <p>{{ trans('general.entries.no_location') }}</p>
                                </div>
                        @endif <!-- latitude, longitude -->
                        </div> <!-- tab-pane -->

                        <div class="tab-pane" id="comments">
                            <p class="help-block">{{trans('general.entries.public_comments')}}</p>
                            <div class="fb-comments" data-href="{{ URL::to('entry/'.$entry->id.'/view/') }}" data-numposts="5" data-colorscheme="light" data-width="800" style="width: 100%">
                            </div>
                        </div>  <!-- tab-pane -->
                    </div> <!-- tab-content -->

                    <!-- The Modal -->
                    <div id="myModal" class="imageModal">
                        <!-- The Close Button -->
                        <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
                        <!-- Modal Content (The Image) -->
                        <img class="modal-content" id="img01">
                    </div>
            </div> <!-- container -->
    </section>
@stop

@section('custom_js')
    @javascript('entry', $entry->toArray())
    @javascript('community', $whitelabel_group->toArray())

    <script src="{{ Helper::cdn('js/compiled/maps-entry.js') }}"></script>

    <script>
        $(document).ready(function () {

            initializeEntryMap(window.entry, window.community, {
                editable: false,
            })

            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            if ($("#entryImage").length) {
                var img = document.getElementById('entryImage');
                var modalImg = document.getElementById("img01");
                img.onclick = function () {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                }
            }

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }
            //$("#messageSubmit").attr('disabled','disabled'); // disable button until message has been types

            $("#offerForm").submit(function () {

                $.ajax({
                    type: "POST",
                    url: "{{ route('messages.create.save', [$entry->created_by, $entry->id]) }}",
                    data: $('#offerForm').serialize(),

                    success: function (data, textStatus, xhr) {
                        if (data.success) {
                            $('#msgSuccess').html(data.message);
                            $('.ajax_success').removeClass('hidden');
                            $('.alert.alert-success.fade').delay(4000).fadeOut('slow');
                        }
                        else {
                            $('#msgError').html(data.message);
                            $('.ajax_error').removeClass('hidden');
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.log('xhr.status = ' + xhr.status + '\n' +
                            'thrown error = ' + errorThrown + '\n' +
                            'xhr.statusText = ' + xhr.statusText + '\n' +
                            'textStatus = ' + textStatus + '\n' +
                            'responseText = ' + xhr.responseText);

                        $('#offerStatusbox').addClass('alert alert-danger');
                        $('#offerStatus').html('Something went wrong :(');
                    }
                });

                return false;
            });
        });

    </script>

@stop
