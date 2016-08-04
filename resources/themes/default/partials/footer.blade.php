
<!-- FOOTER -->
<footer id="footer">
	<div class="copyright">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4 col-sm-1 col-xs-2 margin-top-6 margin-bottom-6">
              <a href="/" class="w-nav-brand">
                <img width="20" src="{{ asset('/assets/img/hp/anyshare-mark.png') }}" class="footer-mark">
              </a>
            <!-- &copy; {{ date("Y") }} All Rights Reserved, AnyShare Society. -->
            </div> <!-- col 3 -->

            <div class="col-md-6 col-sm-9 col-xs-6 margin-top-6 margin-bottom-6">
              <ul class="margin-bottom-6 padding-bottom-0 list-inline mobile-block pull-right">
                <li><a href="/about">About</a></li>
                <!-- <li><a href="http://blog.massmosaic.com">News</a></li> -->
                <li><a href="/coop">Coop</a></li>
                <li><a href="/terms">Terms</a></li>
                <li><a href="/privacy">Privacy</a></li>
              </ul>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 socials margin-top-0 margin-bottom-0">
              <a href="https://www.facebook.com/anyshare.coop/" class="social-icon social-icon-sm social-fa fa-sm social-fa fa-transparent social-grayscale pull-md-right pull-lg-right" data-toggle="tooltip" data-placement="top" title="Facebook" >
                <i class="fa fa-facebook"></i>
                <i class="fa fa-facebook"></i>
              </a>

              <a href="https://twitter.com/anyshare_coop" class="social-icon social-icon-sm social-fa fa-sm social-fa fa-transparent social-grayscale pull-md-right pull-lg-right" data-toggle="tooltip" data-placement="top" title="Twitter">
                <i class="fa fa-twitter"></i>
                <i class="fa fa-twitter"></i>
              </a>
            </div>
            

<!-- 
              <a href="https://plus.google.com/+Massmosaic/videos" class="social-icon social-icon-sm social-fa fa-sm social-fa fa-transparent social-grayscale pull-md-right pull-lg-right" data-toggle="tooltip" data-placement="top" title="Google plus">
                <i class="fa fa-google"></i>
                <i class="fa fa-google"></i>
              </a>
            </div> --><!-- col 2 -->

        	</div>
        </div>
      </div>
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

<script type="text/javascript" src="https://s3.amazonaws.com/assets.freshdesk.com/widget/freshwidget.js"></script>
<script type="text/javascript">
FreshWidget.init("", {"queryString": "&widgetType=popup&formTitle=Help+%26+Support&submitThanks=Thank+you+for+your+feedback.+We'll+be+in+touch+soon.", "utf8": "✓", "widgetType": "popup", "buttonType": "text", "buttonText": "Support", "buttonColor": "white", "buttonBg": "#686868", "alignment": "3", "offset": "90%", "submitThanks": "Thank you for your feedback. We'll be in touch soon.", "formHeight": "500px", "url": "https://anyshare.freshdesk.com"} ); </script>
@yield('moar_scripts')
