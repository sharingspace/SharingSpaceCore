
<!-- FOOTER -->
			<footer id="footer">
        <div class="container padding-top-30 padding-bottom-30 margin-bottom-10">

					<div class="row">
            <div class="col-md-5">
              <p class="margin-bottom-10">AnyShare Society is the first completely Cooperative business in the United States. We allow all stakeholders to own, vote, and share revenue! We're thrilled and so are our members! After all, we ARE you! <a style="color:white;" href="/coop">Read more</a></p>
            </div> <!-- col 5 -->

            <div class="col-md-5">
									<!-- Newsletter Form -->
									<p class="margin-bottom-10">Subscribe to Our <strong>Newsletter</strong></p>

									<form class="validate margin-bottom-10" method="post" data-success="Subscribed! Thank you!" data-toastr-position="bottom-right">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
											<input type="email" id="email" name="email" class="form-control required" placeholder="Enter your Email">
											<span class="input-group-btn">
												<button class="btn btn-success" type="submit">Subscribe</button>
											</span>
										</div>
              </form> <!-- /Newsletter Form -->
            </div> <!-- col 5 -->

            <div class="col-md-2 col-sm-2 hidden-xs margin-bottom-0 pull-right">
                  <p class="margin-bottom-10">Follow Us</p>
                  <a href="#" class="social-icon social-fa fa-sm social-fa fa-transparent social-facebook pull-left" data-toggle="tooltip" data-placement="top" title="Facebook">
                    <i class="fa fa-facebook"></i>
                    <i class="fa fa-facebook"></i>
                  </a>

                  <a href="#" class="social-icon social-fa fa-sm social-fa fa-transparent social-twitter pull-left" data-toggle="tooltip" data-placement="top" title="Twitter">
                    <i class="fa fa-twitter"></i>
                    <i class="fa fa-twitter"></i>
                  </a>

                  <a href="#" class="social-icon social-fa fa-sm social-fa fa-transparent social-gplus pull-left" data-toggle="tooltip" data-placement="top" title="Google plus">
                    <i class="fa fa-google"></i>
                    <i class="fa fa-google"></i>
                  </a>
                  <!--
                  <a href="#" class="social-icon social-fa fa-sm social-fa fa-transparent social-linkedin pull-left" data-toggle="tooltip" data-placement="top" title="Linkedin">
                    <i class="fa fa-linkedin"></i>
                    <i class="fa fa-linkedin"></i>
                  </a>

                  <a href="#" class="social-icon social-fa fa-sm social-fa fa-transparent social-rss pull-left" data-toggle="tooltip" data-placement="top" title="Rss">
                    <i class="fa fa-rss"></i>
                    <i class="fa fa-rss"></i>
                  </a> -->
								</div> <!-- col 12 -->
							</div> <!-- row -->
						</div> <!-- col 4 -->
					
						
          @if(0)
						<div class="col-md-4">
							<h4 class="letter-spacing-1">New Sharing Hubs</h4>

							<div class="footer-gallery lightbox" data-plugin-options='{"delegate": "a", "gallery": {"enabled": true}}'>
								<a href="#">
									<img src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="106" height="70" alt="" />
								</a>
								<a href="#">
									<img src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="106" height="70" alt="" />
								</a>
								<a href="assets/img/demo/1200x800/12-min.jpg">
									<img src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="106" height="70" alt="" />
								</a>
								<a href="#">
									<img src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="106" height="70" alt="" />
								</a>
								<a href="#">
									<img src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="106" height="70" alt="" />
								</a>
								<a href="#">
									<img src="http://lorempixel.com/{{ rand(100, 200) }}/{{ rand(100, 200) }}" width="106" height="70" alt="" />
								</a>
							</div>
						</div>
          @endif

					</div> <!-- row -->
				</div> <!-- container -->

				<div class="copyright">
					<div class="container">
					
						<ul class="pull-right nomargin list-inline mobile-block">
        <li><a href="http://blog.massmosaic.com">News</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/coop">Coop</a></li>
        <li><a href="/pricing">Pricing</a></li>
        <li><a href="/terms">Terms &amp; Conditions</a></li>
							<li><a href="/privacy">Privacy</a></li>
						</ul>
						&copy; All Rights Reserved, AnyShare Society.
					</div>
				</div>
			</footer>
			<!-- /FOOTER -->

    <!-- JAVASCRIPT FILES -->
    <script type="text/javascript" src="/assets/js/scripts.js"></script>

    @yield('moar_scripts')
