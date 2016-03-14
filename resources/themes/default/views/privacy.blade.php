@extends('layouts.master')

{{-- Page title --}}
@section('title')
  {{ trans('general.privacy.title') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')
<section class="padding-top-0">
  <div class='page_banner sharing_fixed_banner'>
    <h1 class="sr-only">{{trans('privacy.title') }}</h1>
  </div>
</section>

<!-- -->
<section>
  <div class="container margin-top-20">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <p>{{trans('privacy.intro') }}</p>

        <h2>{{ trans('privacy.what_info.title') }}</h2>
        <h3>{{ trans('privacy.what_info.user_provided.title') }}</h3>
        <p>{{ trans('privacy.what_info.user_provided.p1') }}</p>
        <p>{{ trans('privacy.what_info.user_provided.p2') }}</p>
        <p>{{ trans('privacy.what_info.user_provided.p3') }}</p>
        <p>{{ trans('privacy.what_info.user_provided.p4') }}</p>

        <h3>{{ trans('privacy.what_info.automatically.title') }}</h3>
        <p>{{ trans('privacy.what_info.automatically.p1') }}</p>
        <p><strong>{{ trans('privacy.what_info.automatically.q1') }}</strong></p>
        <p>{{ trans('privacy.what_info.automatically.a1') }}</p>
        <p><strong>{{ trans('privacy.what_info.automatically.q2') }}</strong></p>
        <p>{{ trans('privacy.what_info.automatically.a2') }}</p>
        <ul>
          <li class="margin-bottom-10">{{ trans('privacy.what_info.automatically.li1') }}</li>
          <li class="margin-bottom-10">{{ trans('privacy.what_info.automatically.li2') }}</li>
          <li class="margin-bottom-10">{{ trans('privacy.what_info.automatically.li3') }}</li>
          <li class="margin-bottom-10">{{ trans('privacy.what_info.automatically.li4') }}</li>
        </ul>

        <h3>{{ trans('privacy.opt_out_rights.title') }}</h3>
        <p>{{ trans('privacy.opt_out_rights.p1') }}</p>

        <h3>{{ trans('privacy.data_retension.title') }}</h3>
        <p>{{ trans('privacy.data_retension.p1') }}</p>

        <h3>{{ trans('privacy.third_parties.title') }}</h3>
        <p>{{ trans('privacy.third_parties.p1') }}</p>
        <p>{{ trans('privacy.third_parties.p2') }}</p>
        <p>{{ trans('privacy.third_parties.p3') }}</p>

        <h4>{{ trans('privacy.third_parties.tools.ga.title') }}</h4>
        <p>{{ trans('privacy.third_parties.tools.ga.p1') }}</p>
        <h4>{{ trans('privacy.third_parties.tools.crazy_egg.title') }}</h4>
        <p>{{ trans('privacy.third_parties.tools.crazy_egg.p1') }}</p>
        <h4>{{ trans('privacy.third_parties.tools.zendesk.title') }}</h4>
        <p>{{ trans('privacy.third_parties.tools.zendesk.p1') }}</p>

        <h3>{{ trans('privacy.social_logins.title') }}</h3>
        <p>{{ trans('privacy.social_logins.p1') }}</p>
        <h4>{{ trans('privacy.social_logins.facebook.title') }}</h4>
        <p>{{ trans('privacy.social_logins.facebook.p1') }}</p>
        <h4>{{ trans('privacy.social_logins.twitter.title') }}</h4>
        <p>{{ trans('privacy.social_logins.twitter.p1') }}</p>
        <h4>{{ trans('privacy.social_logins.google.title') }}</h4>
        <p>{{ trans('privacy.social_logins.google.p1') }}</p>
        <h4>{{ trans('privacy.social_logins.github.title') }}</h4>
        <p>{{ trans('privacy.social_logins.github.p1') }}</p>

        <h3>{{trans('privacy.children.title') }}</h3>
        <p>{{trans('privacy.children.p1') }}</p>

        <h3>{{trans('privacy.security.title') }}</h3>
        <p>{{trans('privacy.security.p1') }}</p></p>

        <h3>{{trans('privacy.changes.title') }}</h3>
        <p>{{trans('privacy.changes.p1') }}</p>

        <h3>{{trans('privacy.contact.title') }}</h3>
        <p>{{trans('privacy.contact.p1') }} <a href="mailto:info@massmosaic.com">info@anysha.re</a></p>
      </div>
    </div>
  </div>
</section>
<!-- / -->



@stop
