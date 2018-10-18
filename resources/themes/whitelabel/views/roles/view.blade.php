@extends('layouts.master')

@section('title')
    @if(isset($model))

      {{ trans('general.role.edit') }}

    @else

      {{ trans('general.role.create') }}

    @endif

    :: @parent

@stop
@if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->any() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif

@section('content')
    @if(isset($model))
      {!! Form::model($model,['route' => 'admin.role.update' , 'method' => 'post','id'=>'form','files'=>true]) !!}
      {!! Form::hidden('id', $model->id) !!}
    @else    
      {!! Form::open(['route' => 'admin.role.store', 'method' => 'post', 'role'=>'form','id'=>'form','files'=>true]) !!}
    @endif
      @include("roles.html")
    {{ Form::close() }}
@stop

@section('custom_js')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#permissions').change(function() {
          if($(this).is(':checked')) {
            $('.checkall').prop("checked", true);
          }else {
            $('.checkall').prop("checked", false);
          }
      });
    });
  </script>
@endsection