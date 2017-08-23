@extends('layouts.master')

@section('content')

 
      <!--
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      | Feature 10
      |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
      !-->

      <section class="section overflow-hidden bg-gray py-150">
        <div class="container-wide">
          <div class="row gap-y align-items-center">

            <div class="col-lg-6 align-self-center">
              <img class="shadow-3" src="{{ asset('assets/corporate/img/ss/ss-mall.jpg') }}" alt="..." data-aos="slide-right" data-aos-duration="1500">
            </div>

            <div class="col-12 col-lg-6 pl-50 pr-80">
              <h2>Self-Aware Spaces</h2>
              <p class="lead">The social fabric of public spaces is disconnected, and largely uncoordinated. The New Economy does not have a sharing platform to connect people’s needs in public spaces. There is a lack of trust and no sense of nearby connection with strangers in public spaces.
</p>

              <br />

              <p>
                <i class="ti-check text-success mr-8"></i>
                <span class="fs-14">People check in to physical space, syncing their data</span>
              </p>

              <p>
                <i class="ti-check text-success mr-8"></i>
                <span class="fs-14">Space coordinates opportunities according to preferences</span>
              </p>

              <p>
                <i class="ti-check text-success mr-8"></i>
                <span class="fs-14">Simply check in and enjoy curated opportunities</span>
              </p>

              <p>
                <i class="ti-check text-success mr-8"></i>
                <span class="fs-14">Turn TV’s into data-driven collaboration tools</span>
              </p>

              <br />
                <a class="btn btn-lg btn-malibu" href="{{ route('_sharing_spaces_waitlist') }}">Join Wait List<i class="fa fa-arrow-right fs-15 ml-8"></i></a>

            </div>
          </div>
        </div>
      </section>


@stop
