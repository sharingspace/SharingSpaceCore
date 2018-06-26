@extends('layouts.master')

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
      {!! Form::model($model,['route' => 'admin.assign-role.update' , 'method' => 'post','id'=>'form','files'=>true]) !!}
      {!! Form::hidden('id', $model->id) !!}
    @else    
      {!! Form::open(['route' => 'admin.assign-role.store', 'method' => 'post', 'role'=>'form','id'=>'form','files'=>true]) !!}
    @endif
      @include("assigned-roles.html")
    {{ Form::close() }}
@stop

@section('custom_js')
@endsection