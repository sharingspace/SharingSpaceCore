@extends('layouts.master')

@section('title')
    @if(isset($model))

      {{ trans('general.apis.edit') }}

    @else

      {{ trans('general.apis.create') }}

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
      {!! Form::model($model,['route' => 'admin.apis.update' , 'method' => 'post','id'=>'form','files'=>true]) !!}
      {!! Form::hidden('id', $model->id) !!}
    @else    
      {!! Form::open(['route' => 'admin.apis.store', 'method' => 'post', 'role'=>'form','id'=>'form','files'=>true]) !!}
    @endif
      @include("apis.html")
    {{ Form::close() }}
@stop

@section('custom_js')

@endsection