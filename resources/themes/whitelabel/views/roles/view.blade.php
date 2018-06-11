@extends('layouts/master')

{{-- Page title --}}
@section('title')
    {{ trans('general.create') }} ::
    @parent
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
      {!! Form::model($model,['route' => $update_route , 'method' => 'post','id'=>'form','files'=>true]) !!}
      {!! Form::hidden('id', $model->id) !!}
    @else    
      {!! Form::open(['route' => 'admin.role.store', 'method' => 'post', 'role'=>'form','id'=>'form','files'=>true]) !!}
    @endif
      @include("roles.html")
    {{ Form::close() }}
@stop