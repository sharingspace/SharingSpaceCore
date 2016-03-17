
<!-- FOOTER -->
<footer id="footer">
	<div class="copyright">
    <div class="container">
      <div class="col-md-4 col-sm-12 pull-md-left text-center-sm  text-center-xs margin-top-10">
        &copy; {{ date("Y") }} All Rights Reserved, AnyShare Society. 
      </div> <!-- col 3 -->

      <div class="col-md-6 col-sm-12 pull-md-left text-center-sm text-center-xs margin-top-10">
        <ul class="text-center nomargin list-inline mobile-block">
          <li><a href="http://blog.massmosaic.com">News</a></li>
          <li><a href="/about">About</a></li>
          <li><a href="/coop">Coop</a></li>
          <li><a href="/pricing">Pricing</a></li>
          <li><a href="/terms">Terms &amp; Conditions</a></li>
          <li><a href="/privacy">Privacy</a></li>
          <li><a href="#" data-toggle="modal" data-target="#subscribe">Newsletter</a></li>
        </ul>
      </div>

      <div class="col-md-2 col-sm-12 socials text-center-sm text-center-xs margin-top-10">
        <a href="#" class="social-icon social-icon-sm social-fa fa-sm social-fa fa-transparent social-grayscale pull-md-right pull-lg-right" data-toggle="tooltip" data-placement="top" title="Facebook" >
          <i class="fa fa-facebook"></i>
          <i class="fa fa-facebook"></i>
        </a>

        <a href="#" class="social-icon social-icon-sm social-fa fa-sm social-fa fa-transparent social-grayscale pull-md-right pull-lg-right" data-toggle="tooltip" data-placement="top" title="Twitter">
          <i class="fa fa-twitter"></i>
          <i class="fa fa-twitter"></i>
        </a>

        <a href="#" class="social-icon social-icon-sm social-fa fa-sm social-fa fa-transparent social-grayscale pull-md-right pull-lg-right" data-toggle="tooltip" data-placement="top" title="Google plus">
          <i class="fa fa-google"></i>
          <i class="fa fa-google"></i>
        </a>
      </div> <!-- col 2 -->
	</div>
  </div>

</footer>
<!-- /FOOTER -->

<div id="subscribe" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Subscribe</h4>
      </div>
      <div class="modal-body">
        <form class="validate margin-bottom-10" method="post" data-success="Subscribed! Thank you!" data-toastr-position="bottom-right">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="email" id="email" name="email" class="form-control required" placeholder="Enter your Email">
            <span class="input-group-btn">
              <button class="btn btn-success" type="submit">Subscribe</button>
            </span>
          </div>
        </form>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> <!-- subscribe -->
    <!-- JAVASCRIPT FILES -->
    <script type="text/javascript" src="/assets/js/scripts.js"></script>

    @yield('moar_scripts')
