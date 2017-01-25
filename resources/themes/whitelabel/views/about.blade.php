@extends('layouts.master')

{{-- Page title --}}
  @section('title')
    {{ trans('general.about') }} ::
  @parent
@stop


@section('content')

<div class="container">
	<div class="row">
    <h1 class="margin-bottom-0 size-24 text-center">About {{$whitelabel_group->name}}</h1>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
      <p  class="about_info"><strong>Started:</strong> <span>{{$whitelabel_group->created_at->format('F jS, Y')}}</span>
      @if (!empty($whitelabel_group->location))
        <br><strong>Location:</strong> <span class="about_info">{{$whitelabel_group->location}}</span>
      @endif
      @if ($whitelabel_group->group_type == 'O')
        <br><strong>Privacy:</strong> <span class="about_info">Open Membership</span> 
        <a href="#" title="An open Share lets anyone join and exchange. It is the most permissive way to build members.""><i class="fa fa-info-circle"></i></a>

      @elseif ($whitelabel_group->group_type == 'C')
        <br><strong>Privacy:</strong> <span class="about_info">Closed, Membership requires approval</span> 
        <a href="#" title="A closed Share lets you approve members before they join. You can also invite members! Visitors can see basic information in its content, but not the details."><i class="fa fa-info-circle"></i></a>
      @else
        <br><strong>Privacy:</strong> <span class="about_info">Secret, Membership is by invitation only</span> 
        <a href="" data-toggle="modal" data-target="#learnPrivacy"><i class="fa fa-info-circle"></i></a>
      @endif
        <br><strong>{{ trans_choice('general.community.exchange_types.title', $whitelabel_group->exchangeTypes->count()) }}</strong>
        <span class="about_info">
          @if ($whitelabel_group->exchangeTypes->count() == 10)
            {{ trans('general.community.exchange_types.all_allowed') }}
          @else
            {{--*/ $exchangeTypes = array() /*--}}
            @foreach ($whitelabel_group->exchangeTypes as $exchange_type)
              {{--*/ $exchangeTypes[] = $exchange_type->name /*--}}
            @endforeach
            {{ implode(', ', $exchangeTypes)}}
            <a href="#" title="This shows options for member exchange on this Share"><i class="fa fa-info-circle"></i></a>
          @endif
        </span>
        <br><strong>Total members:</strong> {{$whitelabel_group->members()->count()}}<br>
        <strong>Total entries:</strong> {{$whitelabel_group->entries()->count()}}
        (wants:</span> {{$whitelabel_group->entries()->where('post_type', 'want')->count()}}
        <a href="#" title="All the needs of the members"><i class="fa fa-info-circle"></i></a>, 
        haves:</span> {{$whitelabel_group->entries()->where('post_type', 'have')->count()}}
        <a href="#" title="All the resources of the members"><i class="fa fa-info-circle"></i></a>)
        </p>

      {!! Markdown::convertToHtml($whitelabel_group->about) !!} 
 	  </div> <!-- col-lg-10 -->
	</div> <!-- row -->
</div> <!-- #container -->

<script type="text/javascript">
  $( document ).ready(function() {
    $( document ).tooltip();
  });
</script>
@stop
