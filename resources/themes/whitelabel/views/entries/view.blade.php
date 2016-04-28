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
		<div class="row">
    	<div class="col-md-4 col-sm-4 col-xs-12 margin-top-20" style="object-fit:contain;">

        @if($images && $images[0]->filename)
          <img src="/assets/uploads/entries/{{ $entry->id }}/{{ $images[0]->filename }}">
        @else
        	<img src="{{ Config::get('app.cdn.default') }}/assets/img/default/new-default-{{{ $entry->post_type }}}.jpg">
        @endif
      </div> <!-- col-md-4 -->

			<div class="col-md-8 col-sm-8 col-xs-12 margin-top-20" style="object-fit:contain;">
      	<div class="row">
        	<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-10">
         		<h1 class="size-18 margin-bottom-0"><span class="sr-only">{{ trans('general.entries.view') }},</span> {{ strtoupper($entry->post_type) }}: {{ $entry->title }}</h1>
          </div>

          @if($entry->author->getDisplayName())
        		<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
        			<strong>By:</strong> {{$entry->author->getDisplayName()}}
            </div>
          @endif


          @if (count($entry->exchangeTypes) > 0)
        		<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
							<?php  $exchanges = array(); ?>
              @for ($i = 0; $i < count($entry->exchangeTypes); $i++)
                <?php array_push($exchanges, strtolower($entry->exchangeTypes[$i]->name)); ?>
              @endfor
              <strong>Exchange types:</strong> {{implode(', ', $exchanges)}}
            </div>
        	@endif
           @if($entry->qty)
          	<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
              <strong>Quantity:</strong> {{$entry->qty}}
						</div>
          @endif
          @if($entry->location)
        		<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
        			<strong>Location:</strong> {{ $entry->location }}
            </div>
          @endif

           @if($entry->description)
        		<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
        			<strong>Description:</strong> {{ $entry->description }}
            </div>
          @endif

          @if($entry->tags)
            <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
              <strong>Keywords:</strong> {{ $entry->tags }}
            </div>
          @endif


      <!-- if user is admin or owner -->
      <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-3">
        @if (Auth::check())
          <div class="listing-actions" style="padding-top: 10px;">

          {{ Form::open(array('route'=>array('entry.delete.save',$entry->id))) }}
            {{ Form::token()}}

            @can('update-entry', $entry)

              <a href="{{ route('entry.edit.form', $entry->id) }}" class="btn btn-xs btn-info tooltipEnable" data-container="body" data-toggle="tooltip" data-placement="bottom" title="Edit This {{{ strtoupper($entry->post_type) }}}" data-mm-track-label="Edit from Tile View">
              <i class="fa fa-pencil"></i> Edit</a>

              @if ($entry->completed_at=='')
                <a href="{{ route('entry.completed', $entry->id) }}" class="btn btn-xs btn-success tooltipEnable" data-container="body" data-toggle="tooltip" data-placement="bottom" title="Mark this {{{ strtoupper($entry->post_type) }}} as completed" data-mm-track-label="Mark as Completed from Tile View">
                <i class="glyphicon glyphicon-ok"></i> Mark Completed</a>
              @endif
                {{ Form::button('<i class="fa fa-trash"></i> Delete', array('type' => 'submit', 'class' => 'btn btn-xs btn-warning'))}}
            @endcan

          {{ Form::close() }}

        </div> <!-- listing-actions -->
        @endif <!-- endif user is admin or owner -->
      </div>  <!-- col-md-12 -->
 		</div> <!-- col-sm-8 -->
		</div>


		<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:20px">

			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
			 <li class="active"><a href="#make_offer" role="tab" data-toggle="tab">

				@if (Auth::check())
					@if (Auth::user()->id == $entry->created_by)
						View Offers
					@else
						Make Offer
					@endif
				@else
					Make Offer
				@endif
              </a></li>

              @if ($images && count($images) > 1)
				<li><a href="#view_images_tab" role="tab" data-toggle="tab">More Images</a></li>
              @endif

				<li><a id="view_map_tab" href="#view_map" role="tab" data-toggle="tab">View Map</a></li>
				<li><a id="view_comment_tab" href="#comments" role="tab" data-toggle="tab">Comments</a></li>
    		</ul> <!-- nav-tabs -->

			<!-- Tab panes -->
			<div class="tab-content">

				<div class="tab-pane active" id="make_offer">
					<div class="col-xs-12 col-sm-12 col-md-12 margin-top-6">

						@if (Auth::check())
							@if (Auth::user()->id != $entry->created_by)
								@if ((!$entry->expired) && ($entry->completed_at==''))
									<p class='margin-bottom-6 pull-right size-11'><i class='fa fa-asterisk'></i> Only the owner of this entry can see these messages.</p>
						            <form action="{{ route('messages.create.save') }}" method="post">
                                    {!! csrf_field() !!}
                                    <!--MAKE AN OFFER-->

                                      <div class="col-xs-12 col-sm-12 col-md-12 form-group clearfix">
                                        <textarea rows="5" name="message" id="message" class="form-control" placeholder='your offer &#133;'>{{{ Input::old('message') }}}</textarea>
                                      </div>  <!-- col-xs-12 -->
                                      <p class='margin-bottom-6 pull-left'>I would like to:</p>

            							<div class="col-xs-12 col-sm-12 col-md-12" style="padding-bottom: 20px;">
                                        <div class="form-group {{ $errors->first('message', 'has-error') }}">

                                          <ul class="exchange_types">
                                             @if (count($entry->exchangeTypes) > 0)
                                               @for ($i = 0; $i < count($entry->exchangeTypes); $i++)
                                               <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                                  <input type="checkbox" name="{{{ strtolower($entry->exchangeTypes[$i]->name) }}}" value="1" id="{{{ strtolower($entry->exchangeTypes[$i]->name) }}}"> {{{ $entry->exchangeTypes[$i]->name }}}
                                              </div> <!-- col-sm-3 -->
                                            @endfor
                                          @endif
								        </ul> <!-- exchange_types -->
							        </div> <!-- form-group -->

							{{ $errors->first('message', '<div class="alert-no-fade alert-danger col-sm-12"> :message</div>') }}
						</div> <!-- col-xs-12 -->
                        <div class="col-md-9 col-sm-12 col-xs-12 form-group" id="amountbox" style="display:none;">
                          <div class="col-md-3">
                            <p class="help-block">Offer an amount</p>
                          </div>
                          <div class="input-group col-md-3">
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-usd"></span>
                            </span>
                            <input type="text" id="amount" name="amount" class="form-control" value="{{{ Input::old('amount') }}}">
                          </div>
                          <div class="col-md-12 form-group">
                            {{ $errors->first('post_type', '<div class="alert-no-fade alert-danger col-sm-12"> :message</div>') }}
                          </div>
                        </div>  <!-- col-md-9 -->

                        <div class="col-xs-12 col-sm-12  col-md-3  form-group pull-right">
                          <button type="submit" class="btn btn-warning pull-right">Make Offer</button>
                        </div>  <!-- col-md-3 -->
                      </form>

										@else  <!-- expired -->
											@if ($entry->expired)
												<p>Sorry, this tile has expired!</p>
											@elseif ($entry->completed_at!='')
												<p>This entry has been completed and is no longer available for offers. Still interested? <a href="{{ route('entry.create.form') }}">List it as a want or a have</a>!</p>
											@endif
										@endif <!-- expired -->
									@else
										<p style="font-size: x-small;margin-bottom:10px;">It would be nice to see a list such as the faked up list below</p>
                    <div class="clearfix"><!-- notification item -->
  										<i class="fa fa-envelope"></i>
  										<button type="button" class="btn btn-link" data-toggle="modal" data-target="#offer1">Lorem ipsum Dolor</button>
										</div><!-- /notification item -->

              			<div class="clearfix"><!-- notification item -->
  										<i class="fa fa-envelope"></i>
                      <button type="button" class="btn btn-link" data-toggle="modal" data-target="#offer1">Biggus Lorem ipsum Dolor</button>
                    </div><!-- /notification item -->
									@endif <!-- user -->

								@else
									<p>Please <a class="btn btn-warning btn-xs" href="/auth/signin">Sign in</a> or <a class="btn btn-info btn-xs" href="/auth/signup">Sign up</a> to make an offer</p>
								@endif <!-- logged in -->

								</div> <!-- col-xs-12 -->
							</div> <!-- tab-pane -->

							<div class="tab-pane" id="view_images_tab">
								@if($images)
              	  @foreach ($images as $image)
                		<div class="col-xs-3 col-sm-3 col-md-3" style="margin-top:20px;object-fit:contain;">
            					<img src="/assets/uploads/entries/{{ $entry->created_by }}/{{ $image->filename }}" height="250" width="250" border="1">
                  	</div>
          				@endforeach
          			@endif
							</div>


							<div class="tab-pane" id="view_map">
								<!--MAP-->
								@if (($entry->latitude!='') && ($entry->longitude!=''))

								<div id="map" style="height: 250px;"></div>

									<script>
									$( document ).ready(function() {
										map = new L.Map('map');

										// create the tile layer with correct attribution
										var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
										var osmAttrib='Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
										var osm = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 14, attribution: osmAttrib});

										// start the map in South-East England
										map.setView(new L.LatLng({{{ $entry->latitude }}}, {{{ $entry->longitude }}}),12);
										map.addLayer(osm);
										var marker = L.marker([{{{ $entry->latitude }}}, {{{ $entry->longitude }}}]).addTo(map);
									});
									</script>

									<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
									<script src="{{ Config::get('app.cdn.default') }}/js/leaflet.markercluster-src.js"></script>


									<script>
									$(window).click(function(){
									  map.invalidateSize();
									});
									</script>


								@else
									<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:20px;">
										<p>The owner of this tile has not posted any location information yet.</p>
									</div>
								@endif <!-- latitude, longitude -->

             </div> <!-- tab-pane -->



								<div class="tab-pane" id="comments">
									<p class="help-block">Comments posted here are publicly viewable.</p>
									<div class="fb-comments" data-href="{{{ URL::to('entry/'.$entry->id.'/view/') }}}" data-numposts="5" data-colorscheme="light" data-width="800" style="width: 100%"></div>
							</div>  <!-- tab-pane -->
             </div> <!-- tab-content -->
					</div> <!-- col-xs-12 -->
				</div> <!-- row -->





				</div> <!-- row -->
<!-- <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal2">Make Offer</button> -->
	</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div id="offer1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lorem ipsum Dolor</h4>
      </div>
      <div class="modal-body">
        <p>Nulla scelerisque diam sed dui mattis fermentum. Sed vel elit quam. Fusce et urna facilisis, commodo lorem at, mattis nisi. Mauris nibh mauris, elementum pulvinar metus at, ornare faucibus neque. Praesent placerat odio metus, eget condimentum erat maximus sit amet. </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
$(document).ready(function () {
    $("input#submit").click(function(){
     /*   $.ajax({
            type: "POST",
            url: "process.php", //process to mail
            data: $('form.contact').serialize(),
            success: function(msg){
                $("#thanks").html(msg) //hide button and show thank you
                $("#form-content").modal('hide'); //hide popup
            },
            error: function(){
                alert("failure");
            }
        }); */
    });
});
</script>

@stop
