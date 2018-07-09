<section>
    <div class="container margin-top-20">
        <div class="row">
            <!-- payment form -->
            <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off" class="sky-form boxed clearfix">
                {!! csrf_field() !!}

                <header>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 text-muted">
                            <h2>
                                @if(isset($id))
                                    {!!trans('general.role.edit') !!}
                                @else
                                    {!!trans('general.role.create') !!}
                                @endif
                            </h2>
                        </div>
                    </div>
                </header>

                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <!-- Name -->
                        <div class="form-group {{ $errors->first('name', ' has-error') }}">
                            <label for="name" class="input">{{trans('general.role.name')}} *
                                <input type="text" name="name" class="form-control" placeholder="{{trans('general.role.name_placeholder')}}" required="" value="{{ $model->name or '' }}">
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </label>
                        </div>
                    </div>

                </div>
                <div class="row">   
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="panel panel-default">
                            <div class="panel-heading"> 
                                <label class="checkbox">
                                {{ Form::checkbox('checkall', '', false, ['class' => 'exchanges', 'id' => 'permissions']) }}
                                <i></i>Permissions
                                </label>
                            </div>
                            <div class="panel-body">
                                @foreach($permissions as  $permission)
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="checkbox col-md-12 margin-bottom-10">
                                                {{ Form::checkbox('permissions['.$permission->id.']', $permission->id, 
                                                isset($role_permissions) && in_array($permission->id,$role_permissions)?true:false, ['class' => 'exchanges checkall']) }}
                                                    <i></i> {{ $permission->display_name }}
                                            </label>
                                        </div>
                                    </div>        
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
            </form>          
        </div>
            
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