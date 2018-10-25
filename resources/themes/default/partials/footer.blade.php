<!-- Footer -->
<footer class="site-footer bg-inverse">
    <div class="container">
        <div class="row gap-y align-items-center">
            <div class="col-md-2 hidden-sm-down">
                <p class="text-center text-lg-left">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/corporate/img/logo-mark-inverse.png')}}" alt="logo-mark"></a>
                </p>
            </div>

            <!-- <div class="col-12 col-md-7">
                <ul class="nav nav-primary nav-hero">
                    <li class="nav-item"><a class="nav-link" href="{{ route('about')}}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('coop')}}">Coop</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://anyshare.freshdesk.com/">Support</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('privacy')}}">Privacy</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tos')}}">Terms</a></li>
                </ul>
            </div> -->

            <div class="col-7">
            </div>
            <div class="col-3 hidden-sm-down">
                <div class="social text-center text-lg-right pull-right">
                    <a class="social-facebook" href="https://www.facebook.com/anyshare.coop"><i class="fa fa-facebook"></i></a>
                    <a class="social-twitter" href="https://twitter.com/anyshare_coop"><i class="fa fa-twitter"></i></a>
                    <a class="social-youtube" href="https://www.youtube.com/user/MassMosaic"><i class="fa fa-youtube"></i></a>
                    <a class="social-github" href="https://github.com/anyshare"><i class="fa fa-github"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- add the coloured bottom band -->
    <div class="footer-rainbow"></div>
</footer>

<!-- END Footer -->

<!-- Drawer -->
<div class="drawer">
    <div class="drawer-content">
        <ul class="nav nav-primary nav-hero flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('_sharing_networks') }}">Sharing Networks</a>
            </li>
        </ul>

        <ul class="nav nav-primary flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('_sharing_networks') }}"><i class="fa fa-caret-right"></i> Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('_how_it_works') }}"><i class="fa fa-caret-right"></i> How it works</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('_sharing_examples') }}"><i class="fa fa-caret-right"></i> Examples</a>
            </li>
        </ul>
        <br/>

        <ul class="nav nav-primary nav-hero flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('_sharing_spaces') }}">Sharing Spaces</a>
            </li>
        </ul>

        <ul class="nav nav-primary flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('_sharing_spaces') }}"><i class="fa fa-caret-right"></i> Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('_sharing_spaces_waitlist') }}"><i class="fa fa-caret-right"></i> Wait List</a>
            </li>
        </ul>
        <br/>

        <ul class="nav nav-primary flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('memberships') }}">Memberships</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('coop') }}">Coop</a>
            </li>
        </ul>
        <hr/>

        <div class="social social-boxed social-rounded text-center">
            <a class="social-facebook" href="https://www.facebook.com/anyshare.coop/"><i class="fa fa-facebook"></i></a>
            <a class="social-twitter" href="https://twitter.com/anyshare_coop"><i class="fa fa-twitter"></i></a>
            <a class="social-youtube" href="https://www.youtube.com/user/MassMosaic"><i class="fa fa-youtube"></i></a>
            <a class="social-github" href="https://github.com/anyshare"><i class="fa fa-github"></i></a>
        </div>
        <br/>

        <div class="row">
            <div class="col-6">
                <a class="btn btn-sm btn-block btn-malibu-outline" href="{{ route('login') }}">Sign In</a>
            </div>

            <div class="col-6">
                <a class="btn btn-sm btn-block btn-malibu" href="{{ route('register') }}">Sign Up</a>
            </div>
        </div>
    </div>

    <button class="drawer-close"></button>
    <div class="drawer-backdrop"></div>
</div>
<!-- END Drawer -->

<!-- JAVASCRIPT FILES -->
<script src="{{ asset('assets/corporate/js/core.min.js')}}"></script>
<script src="{{ asset('assets/corporate/js/thesaas.min.js')}}"></script>
<script src="{{ asset('assets/corporate/js/script.js')}}"></script>
<script type="text/javascript" src="https://s3.amazonaws.com/assets.freshdesk.com/widget/freshwidget.js"></script>

@yield('moar_scripts')
