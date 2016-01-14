@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.edit') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- -->
			<section>

				<div id="add_tile_wrapper" class="container margin-top-20">
					<div class="row">
						<!-- Entry -->
						<div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
							<div class="row">

                <h1 class="size-16 uppercase">{{ trans('general.entries.edit') }}</h1>
                <p>{{ trans('general.entries.create_subheadline') }}</p>
                <!-- entry form -->

                <form method="post" action="{{ route('entry.edit.save', $entry->id) }}" enctype="multipart/form-data" autocomplete="off" class="nomargin">
                  {!! csrf_field() !!}
                  <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="4096000" />


                  <div class="clearfix"></div>
                  <fieldset class="nomargin">

                    <div class="col-md-2 margin-bottom-10 {{ $errors->first('post_type', ' has-error') }}">
                        {!! Form::select('post_type', $post_types, $entry->post_type) !!}

                    </div>
                    <div class="col-md-7 margin-bottom-10 {{ $errors->first('title', ' has-error') }}">
                      <!-- Name -->
                      <label class="input">
                        <input type="text" name="title" id="title" class="form-control" placeholder="Description" value="{{ Input::old('title', $entry->title) }}">
                      </label>
                    </div>
                    <div class="col-md-3 margin-bottom-10">
                    	<button type="button" id="pref_button"  class="btn btn-info btn-md" style="float:right;"><i class="fa fa-cogs fa-lg" style="margin-right:10px;"></i><i class="fa fa-caret-down fa-lg"></i></button>
                      <button class="btn btn-success" id="quickAdd" name="quickAdd" value="quickAdd" style="margin-right:10px;float:right;"><i class="fa fa-sign-in fa-lg" style="margin-right:5px;"></i>Save</button>

                    </div>
                    <!--
                    Added tiles ....
                    -->

                    <div class="col-md-12 col-sm-12 col-xs-12" id="added_heading">
                      <h4 class="text-left">You Added</h4>
                    </div> <!-- col-md-12 -->

                    <div class="col-md-12 col-sm-12 col-xs-12 tile_container" id="tile_1" style="display:none;">
                      <div class="row" style="margin-bottom:7px;">
                        <div class="tile_info col-md-11 col-sm-11 col-xs-11" >
                          <!-- exchange types, location etc -->
                        </div> <!-- col-md-10 tile_info  -->

                        <div class="col-md-1 col-sm-1 col-xs-1">
                        	<button type="button" class="more_button btn btn-info btn-md" style="float:right;">more</i> <i class="fa fa-caret-down fa-lg"></i></button>
                        </div> <!-- col-md-2 -->

                        <!--
                        More controls ....
                        -->

                        <div class="more_controls col-md-12 col-sm-12 col-xs-12" style="display:none;margin-top:10px;">
                          <div class="image_upload">
                            <label for="fileupload_" class="sr-only">Upload image</label>
                            <input id="fileupload_" class="file_upload" type="file" onchange="handleFile(this.files, this.id)" accept="image/gif, image/jpeg, image/png"/></label>

                            <button type="button" id='button_' class="smooth_font pull-left image_button btn btn-info btn-md">image <i class="fa fa-upload fa-lg"></i></button>
                            <span class='too_large smooth_font' style="display:none;">File exceeds the 4MB maximum</span>

                            <div class="percentage"></div>
                          </div> <!-- image_upload -->


            							<button type="button" class="button_edit smooth_font btn btn-info btn-md"  style="float:right;margin-left:10px;font-size:13px;">edit <i class="fa fa-pencil fa-lg"></i></button>

                          <button type="button" class="button_delete smooth_font btn btn-warning btn-md"  style="float:right;margin-left:10px;background-color:rgba(255,0,0,0.6);font-size:13px;">delete <i class="fa fa-times fa-lg"></i></button>

                        </div> <!-- more_controls -->
                      </div> <!-- row  -->
                    </div> <!-- col-md-10 tile_container  -->

                  <!--  <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 pull-right">
                      <span class='pull-right' >
                      	<button type="button" id="pref_button" style="border:none; outline: 0;  -webkit-box-shadow: none; box-shadow: none;" >Preferences <i class="fa fa-caret-down"></i></button>
                        <button type="button" id="pref_button" class="fa fa-cogs fa-lg">Preferences <i class="fa fa-caret-down"></i></button>

                    	</span>
                    </div> --><!-- col-md-10 -->

                    <div id="prefs_panel" style="display:none;">
                      <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12"><hr /></div>
                      <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
                        <div class="form-group" style="margin-bottom: 5px;">
                          <input id="selectall" name="all_exchange" type="checkbox" checked value="all"/>
                          <label for="selectall">Exchange in all ways</label>

                          <fieldset>
                            <legend style="border:none;" class="sr-only">Exchange by:</legend>
                            {{ $errors->first('tile_exchange_type', '<div class="alert-no-fade alert-danger col-sm-12"><i class="icon-remove-sign"></i> :message</div>') }}

                            <div class="exchange_types" style="display:none;">

                            </div> <!-- exchange_types  -->
                          </fieldset>
                        </div> <!-- form-group -->
                      </div> <!-- col-md-10 -->

                      <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12">
                        <input id="location_checkbox" name="location" type="checkbox" checked value="no_location">
                        <label for="location">No location</label>

                        <div class="input-group col-md-10">
                          <div id="location_block" style="display:none;" class="col-md-12">

                          </div> <!-- location_block -->
                        </div> <!-- input-group  -->

                        <input id="private_checkbox" name="private" type="checkbox" value="1"/>
                        <label for="private_checkbox">Keep this value private</label>
                      </div> <!-- col-md-10  -->

                      <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12" id="select_hub" style="display:none;margin-top:20px;">
                        <div class="hubs row">
                          @if(isset($groups) && count($groups))
                          <fieldset>
                            <legend style="border:none;">Add to Hubs:</legend>

                          </fieldset>
                          @endif
                        </div> <!-- hubs & row -->
                      </div> <!-- col-md-10 -->
                    </div> <!-- prefs panel -->




                  </fieldset>
                </form>
              </div>
						</div>
					</div>


				</div>
			</section>
			<!-- / -->

      <!-- Modal -->
      <div id="myExamples" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Examples</h4>
            </div>
            <div class="modal-body">
              <p>I want a new bicycle<br />
              I have karate skills I can share<br />
              I want carrot cake for my birthday<br />
              I have the ability to speak French<br />
              I want help cleaning my garage<br />
              I have a pile of scrap wood</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>


@stop
