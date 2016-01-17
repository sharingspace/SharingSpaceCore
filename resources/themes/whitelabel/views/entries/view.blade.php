@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.entries.view') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- -->
<section>
	<div class="container margin-top-20">

		<div class="row">

			<!-- LEFT TEXT -->
			<div class="col-md-12">

				<h2 class="size-16">{{ strtoupper($entry->post_type) }}: {{ $entry->title }}</h2>
				<p>{{ $entry->description }}</p>
        <p>Location: {{ $entry->location }}</p>
        <p>QTY: {{ $entry->qty }}</p>

        @if (count($entry->exchangeTypes) > 0)
          @for ($i = 0; $i < count($entry->exchangeTypes); $i++)
            <li> {{ strtolower($entry->exchangeTypes[$i]->name) }}
          @endfor
        @endif


			</div>
			<!-- /LEFT TEXT -->

    </div>
	</div>
</section>
<!-- / -->



@stop
