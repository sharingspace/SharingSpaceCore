<!-- Header -->
<header class="header header-inverse h-350 p-0 overflow-hidden" data-overlay="7">
  <video class="bg-video" poster="{{ asset('assets/corporate/img/video/workspace.jpg')}}" autoplay loop>
    <source src="{{ asset('assets/corporate/img/video/workspace.mp4')}}" type="video/mp4">
    <source src="{{ asset('assets/corporate/img/video/workspace.webm')}}" type="video/webm">
  </video>

    <div class="container text-center">

      <div class="row h-full">
        <div class="col-12 col-lg-8 offset-lg-2 align-self-center pt-80">
          @if (Route::is('login'))
          <h1>{{trans('general.nav.login') }}</h1>
          <h2>{{trans('auth.signin_to_use') }}</h2>
          @elseif (Route::is('register'))
          <h1>{{trans('general.sign_up') }}</h1>
          <h2>{{trans('general.create_account') }}</h2>
          @elseif (Route::is('community.create.form'))
            <h1 class="heading">{!!trans('general.start_share') !!}</h1>
          @elseif (Route::is('coop'))
            <h1>Our Cooperative</h1>
            <h2>Everyone shares in AnyShare's Success!</h2>
          @elseif (Route::is('_sharing_networks'))
            <h1>{!!trans('general.sharing_networks') !!}</h1>
            <h2>{!!trans('general.learn_share') !!}</h2>
          @elseif (Route::is('_how_it_works'))
            <h1>{!!trans('general.sharing_networks') !!}</h1>
            <h2>{!!trans('general.learn_share') !!}</h2>
          @elseif (Route::is('_sharing_spaces'))
            <h1>{!!trans('general.sharing_spaces') !!}</h1>
            <h2>{!!trans('general.enhance_sharing_spaces') !!}</h2>
          @elseif (Route::is('_sharing_spaces_waitlist'))
            <h1>{!!trans('general.sharing_spaces') !!}</h1>
            <h2>{!!trans('general.sharing_space_notification') !!}</h2>
          @elseif (Route::is('_sharing_examples'))
            <h1>{!!trans('general.sharing_spaces') !!}</h1>
            <h2>{!!trans('general.sharing_examples') !!}</h2>
          @elseif (Route::is('_orders'))
            <h1>{!! trans('general.nav.billing_history') !!}</h1>
          @elseif (Route::is('coop_success'))
          <h1 class="heading">{{ trans('coop.congrats') }}</h1>
          @elseif (Route::is('about'))
          <h1>Sign In</h1>
          <h2>Sign in to use AnyShare</h2><br />
          @elseif (Route::is('product'))
          <h1 class="heading">{{ trans('general.nav.features')}}</h1>
          <h2 class="subheading">{{ trans('general.page_about.product')}}</h2>
          @elseif (Route::is('register'))
          <h1 class="heading">{{ trans('general.nav.try_now') }}</h1>
          <h2 class="subheading">{!! trans('general.nav.join_public_shares_free')!!}</h2>
          @elseif (Route::is('user.history'))
          <h1 class="heading">{{ trans('general.nav.my_orders') }}</h1>
          @elseif (Route::is('register'))
          <h1 class="heading">{{ trans('auth.create_account') }}</h1>
          <h2 class="subheading">{{ trans('auth.join_public_shares') }}</h2>
          @elseif (Route::is('pricing_page'))
          <h1 class="heading">{{ trans('pricing.headline') }}</h1>
          <h2 class="subheading">{{ trans('pricing.sub_headline') }}</h2>
          <a class="cta-button contained-button size-20 margin-top-15 bg-blue" href="{{ route('register') }}">
            {{ trans('home.free_signup') }}
          </a>
          @else  
          <!-- using route name as the h1 -->
          <h1 class="heading">{{ucfirst(Route::getFacadeRoot()->current()->uri())}}</h1>
          @endif
        </div>
      </div>
    </div>
</header>
    <!-- END Header -->



