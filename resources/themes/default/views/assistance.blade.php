@extends('layouts.master')

@section('content')

<section id="pricing">
  <div class="container">
    <div class="row">
    <div class="col-md-12">
  @include('notifications')
            </div>
      <div class="col-md-6 col-md-offset-3">

        <p>We don’t want to stop groups that don’t have the budget to pay, from using AnyShare. If this applies to you, you can apply to receive AnyShare for free. We will consider each application on a case by case basis.</p>

        <p>Please fill in the following application to apply:</p>

        {!! Form::open(array('url' => 'financial_assist')) !!}

        {{ form::label('firstName', 'First name') }}
        {{ form::text('firstName', null, array('size' => '60','required' => 'required')) }}

        {{ form::label('lastName', 'Last name') }}
        {{ form::text('lastName', null, array('size' => '60','required' => 'required')) }}

        {{ form::label('email', 'Email') }}
        {{ form::email('email', null, array('size' => '60','required' => 'required')) }}

        {{ form::label('howUse', 'How will you use AnyShare?') }}
        {{ form::textarea('howUse', null, array('size' => '60x3', 'required' => 'required')) }}

        {{ form::label('budget', 'Explain why you don’t have the budget to pay?') }}
        {{ form::textarea('budget', null, array('size' => '60x3', 'required' => 'required')) }}

        {{ form::label('timePeriod', 'Is this budget limitation temporary or will it continue indefinitely?') }}
        {{ form::textarea('timePeriod', null, array('size' => '60x3', 'required' => 'required')) }}

        {{ form::label('market', 'How will you market your Share?') }}
        {{ form::textarea('market', null, array('size' => '60x3', 'required' => 'required')) }}
        <div class="clearfix"></div>

        {{ Form::submit('Apply', array('class' => 'pull-right btn btn-sm btn-warning')) }}
        {!! Form::close() !!}
        <p>* All fields required</p>

      </div>
    </div>
  </div>
</section>
  <!-- / -->


<script>

jQuery(document).ready(function ($) {


});

</script>
@stop
