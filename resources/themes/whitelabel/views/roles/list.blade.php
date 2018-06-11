@extends('backend.layouts.app')

@section ('title', $title.' | '. config('app.name') )
@section ('module-title', $module_title)
@section ('module-subtitle', $module_subtitle)

@section('admin-lte-plugins')
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{$module_list}}</h3>
      </div>
      @include('backend.action_button')
      <div class="box-body">
        @if(PermissionCheck::authorize($list_permission))
          <table id='table_data' class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 2%">{!! Form::checkbox('null', 1, null, ['id' => 'chkall','class'=>'minimal']) !!}</th>
                <th>Name</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
              @foreach($model as $value)
                <tr>
                  <td>{!! Form::checkbox('chk[]', $value->id, null, ['class' => 'check minimal']) !!}</td>
                  <td>{{ $value->name }}</td>  
                  <td>{{ $value->description }}</td>            
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</div>
     
@endsection

@section('after-scripts')
{{ Html::script('/js/list.js') }}
@endsection