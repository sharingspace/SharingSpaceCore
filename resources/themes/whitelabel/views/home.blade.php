@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.browse') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<section class="info-bar">
	<div class="container">

		<div class="row">

			<div class="col-sm-4">
				<i class="glyphicon glyphicon-globe"></i>
          @if ($whitelabel_group->group_type == 'O')
            <h3 class="uppercase">{{ trans('general.community.open.title') }}</h3>
            <p>{{ trans('general.community.open.text') }}</p>
          @elseif ($whitelabel_group->group_type == 'C')
            <h3 class="uppercase">{{ trans('general.community.closed.title') }}</h3>
            <p>{{ trans('general.community.closed.text') }}</p>
          @elseif ($whitelabel_group->group_type == 'S')
            <h3 class="uppercase">{{ trans('general.community.secret.title') }}</h3>
            <p>{{ trans('general.community.secret.text') }}</p>
          @endif
			</div>

			<div class="col-sm-4">
				<i class="glyphicon glyphicon-user"></i>

				<h3 class="uppercase">{{ $whitelabel_group->members->count() }} {{ trans_choice('general.community.members', $whitelabel_group->members->count()) }}</h3>
				<p>Since {{ $whitelabel_group->created_at->format('M d, Y') }}</p>
			</div>

			<div class="col-sm-4">
				<i class="glyphicon glyphicon-flag"></i>
				<h3 class="uppercase">{{ trans_choice('general.community.exchange_types.title', $whitelabel_group->exchangeTypes->count()) }}</h3>
				<ul class="exchange_types">
          @if ($whitelabel_group->exchangeTypes->count() == 10)
            <li>{{ trans('general.community.exchange_types.all_allowed') }}</li>
          @else
            @foreach ($whitelabel_group->exchangeTypes as $exchange_type)
              <li>{{ $exchange_type->name }}</li>
            @endforeach
          @endif


        </ul>
			</div>

		</div>

	</div>
</section>
<!-- /INFO BAR -->

<div class="col-md-12 margin-top-20">
  <!-- Notifications -->
  @include('notifications')
</div>

@if ($whitelabel_group->about!='')
<section class="container padding-none">
  <div class="row">
      <div class="col-md-12 col-sm-12">
          <p>{{ $whitelabel_group->about }}</p>
      </div>
  </div><!--end row-->
</section>
@endif

<!-- -->
<section>
	<div class="container">

		<ul id="portfolio_filter" class="nav nav-pills margin-bottom-60">

      <li class="filter active">
        <a data-filter="*" href="#">All</a>
      </li>
      @foreach ($whitelabel_group->exchangeTypes as $exchange_types)
        <li class="filter">
          <a data-filter=".{{ Str::slug(strtolower($exchange_types->name)) }}" href="#">{{ $exchange_types->name }}</a>
        </li>
      @endforeach

		</ul>

		<div id="portfolio" class="clearfix portfolio-isotope portfolio-isotope-5">

      @foreach ($entries as $entry)
        <div class="portfolio-item
        @if (count($entry->exchangeTypes) > 0)
          @foreach ($entry->exchangeTypes as $entry_exchange_types)
            {{ Str::slug(strtolower($entry_exchange_types->name)) }}
          @endforeach
        @endif
        ">
      <!-- item -->

				<div class="item-box" style="border: solid 1px #ccc;box-shadow:1px 1px 3px 0 #f2f2f2 padding:5px;">
          @if ($entry->media->count() > 0)
						<figure style="min-height:100px;">
							<span class="item-hover">
								<span class="overlay dark-5"></span>
								<span class="inner">
                  <h2 style="color: white;">{{ ucwords($entry->title) }}</h2>
                  <br><br>
									<a class="ico-rounded" href="{{ route('entry.view', $entry->id) }}">
										<span class="glyphicon glyphicon-option-horizontal size-20"></span>
									</a>
								</span>
							</span>
           
              @foreach ($entry->media as $media)
               <div class="entry_browse">

                <img class="img-responsive" src="/assets/uploads/entries/{{ $entry->id}}/{{ $media->filename }}" width="600" height="399" alt="" style="margin-bottom:14px;">
               
                <a href="#" style="color: blue;font-family:Arial,san-serif;font-size:15px;font-weight:400; color:#0066c0;">{{ucwords($entry->post_type)}}: {{ ucwords($entry->title) }}</a>
                <br>  
                @if ( count($entry->exchangeTypes) > 0)
                  {{--*/ $exchanges = ''; /*--}}
                  @foreach ($entry->exchangeTypes as $entry_exchange_types)
                    {{--*/ $exchanges .= strtolower($entry_exchange_types->name) .", "; /*--}}
                  @endforeach
                  {{ rtrim($exchanges, ', ')}}
                @endif
              </div>
              @endforeach {{-- media --}} 
            </figure>
          @else
            <figure style="min-height:100px;display:table;">
              <span style="display:table-cell;vertical-align:middle;">
                <span class="item-hover ">
                  <span class="inner" style="top:0;display:table-cell;
   vertical-align:middle;">
                    <h2 style="color: white;margin-top:20px;">{{ ucwords($entry->title) }}</h2>
                    <br>
                    <a class="ico-rounded" href="{{ route('entry.view', $entry->id) }}">
                      <span class="glyphicon glyphicon-option-horizontal size-20"></span>
                    </a>
                  </span>
                </span>

                <a href="#" style="color: blue;font-family:Arial,san-serif;font-size:15px;font-weight:400; color:#0066c0;">{{ucwords($entry->post_type)}}: {{ ucwords($entry->title) }}</a>
                <br>  
                @if ( count($entry->exchangeTypes) > 0)
                  {{--*/ $exchanges = ''; /*--}}
                  @foreach ($entry->exchangeTypes as $entry_exchange_types)
                    {{--*/ $exchanges .= strtolower($entry_exchange_types->name) .", "; /*--}}
                  @endforeach
                  {{ rtrim($exchanges, ', ')}}
                @endif {{-- exchange types --}}
                </span>
              </figure>
            @endif {{-- media ? --}} 
 				</div> <!-- item -->
			 </div> <!-- portfolio-item -->
      @endforeach {{-- entry loop --}}

		</div>
	</div>
</section>
<!-- / -->
@stop
