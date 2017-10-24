@extends('layouts.master')

@section('content')

 
<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Feature 7
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section p-0">
    <div class="container-wide">
        <div class="row no-gap">
            <div class="col-12 col-md-6 bg-img" style="background-image: url({{ asset('assets/corporate/img/sn/ex/arco.jpg') }})">
            </div>
            <div class="col-12 offset-md-1 col-md-4 py-90">
                <p><small>Community</small></p>
                <h5>Arcosanti</h5>
                <p>This experimental micro-city uses its Sharing Network to inventory the needs and resources of its residents. They're exploring revolutionary ways to maximize the sustainability of resources in the community, spaces, and natural environment.</p>
                <br />
                <a class="btn btn-malibu" href="https://arcoop.anyshare.coop/">View Now</a>
            </div>

            <div class="col-12 offset-md-1 col-md-4 py-90">
                <p><small>Interest Group</small></p>
                <h5>FairShares Association</h5>
                <p>The FairShares Association uses it's Sharing Network to organize the needs and resources of a group of people who are pushing to see more FairShares Cooperatives established.</p>
                <br />
                <a class="btn btn-malibu" href="https://fairshares.anyshare.coop/">View Now</a>
            </div>

            <div class="col-12 offset-md-1 col-md-6 bg-img" style="background-image: url({{ asset('assets/corporate/img/sn/ex/fs.jpg') }})">
            </div>

            <div class="col-12 col-md-6 bg-img" style="background-image: url({{ asset('assets/corporate/img/sn/ex/chn.jpg') }})">
            </div>

            <div class="col-12 offset-md-1 col-md-4 py-90">
                <p><small>Business</small></p>
                <h5>Commons Hospitality Network</h5>
                <p>The CHN is a network of people striving to expand the commons. They are often traveling in their endeavours and they use their Sharing Network to utilize the commons network to find and offer a bed to sleep in during their travels.</p>
                <br />
                <a class="btn btn-malibu" href="https://chn.anyshare.coop/">View Now</a>
            </div>

            <div class="col-12 offset-md-1 col-md-4 py-90">
                <p><small>Town</small></p>
                <h5>Sdílena Community</h5>
                <p>This Czech town uses their Sharing Network as a gifting and trade network. The community swap meets continue once the doors shut.</p>
                <br />
                <a class="btn btn-malibu" href="https://sdilna.anyshare.coop/">View Now</a>
            </div>

            <div class="col-12 offset-md-1 col-md-6 bg-img" style="background-image: url({{ asset('assets/corporate/img/sn/ex/sdilna.jpg') }})">
            </div>
        </div>
    </div>
</section>


<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| CTA 4
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->

<section class="section section-inverse" style="background-image: url(assets/corporate/img/signup.png)" data-overlay="7">
    <div class="container">
        <div class="row gap-y align-items-center">
            <div class="col-12 col-md-6 text-center text-md-left">
                <h4 class="mb-0"><center>Start a Sharing Network free for 30 days!</center></h4>
            </div>

            <div class="col-12 col-md-6 text-center text-md-right">
                <div class="center-vh">
                    <a class="btn btn-lg btn-malibu" href="{{ route('register') }}">Get Started<i class="fa fa-arrow-right fs-15 ml-8"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
