<section>
    <div class="container margin-top-20">
        <div class="row">
            <!-- payment form -->
            <form method="post" action="#" class="sky-form boxed clearfix">
                {!! csrf_field() !!}
                <header>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 text-muted">
                            <h2>
                                @if(isset($id))
                                    {!!trans('general.apis.edit') !!}
                                @else
                                    {!!trans('general.apis.create') !!}
                                @endif
                            </h2>
                        </div>
                    </div>
                </header>

                <div class="row">   
                    <div class="col-sm-6 col-sm-offset-3">
                        <label>
                            <h4>{!!trans('general.apis.apis-text') !!}</h4>
                        </label>
                    </div>
                </div>
            
                @if(isset($oauth_client))
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-3">
                            <div class="col-sm-3">
                                <label>CLIENT ID :</label>
                            </div>
                            <label>{{$oauth_client->id}}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-3">
                            <div class="col-sm-3">
                                <label>SECRET :</label>
                            </div>
                            <label>{{$oauth_client->secret}}</label>
                        </div>
                    </div>

                @else
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <button class="btn btn-colored">
                                {!!trans('general.apis.enable-api') !!}
                            </button>
                        </div>
                    </div>
                @endif
            </form>          
        </div>
    </div>
</section>