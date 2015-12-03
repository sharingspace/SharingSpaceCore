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
				<h3 class="uppercase">{{ trans_choice('general.community.exchange_types.title', $whitelabel_group->exchange_types->count()) }}</h3>
				<ul class="exchange_types">
          @if ($whitelabel_group->exchange_types->count() == 10)
            <li>{{ trans('general.community.exchange_types.all_allowed') }}</li>
          @else
            @foreach ($whitelabel_group->exchange_types as $exchange_types)
              <li>{{ $exchange_types->name }}</li>
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
            @foreach ($whitelabel_group->exchange_types as $exchange_types)
              <li class="filter">
                <a data-filter=".{{ strtolower($exchange_types->type_name) }}" href="#">{{ $exchange_types->name }}</a>
              </li>
            @endforeach

					</ul>

					<div id="portfolio" class="clearfix portfolio-isotope portfolio-isotope-5">

            @foreach ($entries as $entry)
            <div class="portfolio-item
            @if (count($entry->exchangeTypesNames) > 0)
              @for ($i = 0; $i < count($entry->exchangeTypesNames); $i++)
                {{ strtolower($entry->exchangeTypesNames[$i]->type_name) }}
              @endfor
            @endif
            ">
            <!-- item -->

							<div class="item-box">
								<figure>
									<span class="item-hover">
										<span class="overlay dark-5"></span>
										<span class="inner">
                      <h2 style="color: white;">{{ ucwords($entry->title) }}</h2>
                      <br><br>
											<!-- lightbox -->
											<!-- <a class="ico-rounded lightbox" href="/assets/img/demo/mockups/1200x800/3-min.jpg" data-plugin-options='{"type":"image"}'>
												<span class="fa fa-plus size-20"></span>
											</a>
                      -->

											<!-- details -->

											<a class="ico-rounded" href="{{ route('entry.view', $entry->id) }}">
												<span class="glyphicon glyphicon-option-horizontal size-20"></span>
											</a>
                      <!--
                      <a class="ico-rounded" href="#">
												<span class="glyphicon glyphicon-heart size-20"></span>
											</a>
                    -->


										</span>
									</span>
									<img class="img-responsive" src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="600" height="399" alt="">
								</figure>
							</div>

						</div><!-- /item -->
            @endforeach

					</div>

				</div>
			</section>
			<!-- / -->
@stop
