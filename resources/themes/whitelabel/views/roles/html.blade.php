<section>
        <div class="container margin-top-20">
            <div class="row">
                <!-- payment form -->
                <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off" class="sky-form boxed clearfix">
                    {!! csrf_field() !!}

                    <header>
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 text-muted">
                                <h2>{!!trans('general.role.create') !!}</h2>
                            </div>
                        </div>
                    </header>

                    <div class="row">
                        
                        <div class="col-sm-6 col-sm-offset-3">
                            
                                <!-- Name -->
                                <div class="form-group {{ $errors->first('name', ' has-error') }}">
                                    <label for="name" class="input">{{trans('general.role.name')}} *
                                        <input type="text" name="name" class="form-control" placeholder="{{trans('general.role.name_placeholder')}}" required="" value="{{ old('name') }}">
                                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                    </label>
                                </div>

                                
                            
                        </div>

                       
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <button class="btn btn-colored pull-right">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>