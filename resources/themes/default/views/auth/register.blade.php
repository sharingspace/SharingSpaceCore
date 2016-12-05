@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.register') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<!-- -->
<section>
  <div class="container margin-top-40">

    <div class="row">
      <!-- LOGIN -->
      <div class="col-md-6 col-sm-6">

        <!-- register form -->
        <form class="nomargin sky-form boxed" method="post">
          {!! csrf_field() !!}
          <input type="hidden" name="subdomain" id="subdomain" value="{{!empty($subdomain)?$subdomain:''}}" />

          <header>
            <i class="fa fa-users"></i> Email &hellip;
          </header>

          <fieldset class="nomargin">

            <div class=" margin-bottom-10{{ $errors->first('display_name', ' has-error') }}">
              <label class="input">
                <input type="text" placeholder="{{ trans('general.name') }}" name="display_name" value="{{ old('display_name') }}">
              </label>
              {!! $errors->first('display_name', '<span class="help-block">:message</span>') !!}
            </div>

            <div class=" margin-bottom-10{{ $errors->first('email', ' has-error') }}">
              <label class="input">
                <i class="ico-append fa fa-envelope"></i>
                <input type="text" placeholder="{{ trans('general.user.email') }}" name="email" value="{{ old('email') }}">
                <b class="tooltip tooltip-bottom-right">{{ trans('general.verify') }}</b>
              </label>
              {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>

            <div class=" margin-bottom-10{{ $errors->first('password', ' has-error') }}">
              <label class="input">
                <i class="ico-append fa fa-lock"></i>
                <input type="password" placeholder="{{ trans('general.password') }}" name="password">
                <b class="tooltip tooltip-bottom-right">{{ trans('general.latin_chars') }}</b>
              </label>
              {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
            </div>

            <div class=" margin-bottom-10{{ $errors->first('password_confirmation', ' has-error') }}">
              <label class="input">
                <i class="ico-append fa fa-lock"></i>
                <input type="password" placeholder="{{ trans('general.user.confirm_password') }}"  name="password_confirmation">
                <b class="tooltip tooltip-bottom-right">{{ trans('general.latin_chars') }}</b>
              </label>
              {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
            </div>

            <div class="margin-top-30{{ $errors->first('terms_and_conditions', ' has-error') }}">
              <label class="checkbox nomargin">
                <input class="checked-agree" type="checkbox" name="terms_and_conditions">
                <i></i>{!! trans('auth.accept_tos') !!} 
                <a href="#" data-toggle="modal" data-target="#termsModal">
                  {!! trans('auth.accept_tos2') !!}
                </a>
              </label>
              {!! $errors->first('terms_and_conditions', '<span class="help-block">:message</span>') !!}
            </div>
          </fieldset>

          <div class="row margin-bottom-20">
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{ trans('general.nav.register') }}</button>
            </div>
          </div>

        </form>
        <!-- /register form -->

        <div class="row margin-top-20">
          <div class="col-md-12">
            {!! trans('auth.already_have_account') !!} <a href="../auth/login">{!! trans('auth.signin_now') !!}</a>
          </div>
        </div>
      </div>
      <!-- /LOGIN -->

      <!-- SOCIAL LOGIN -->
      <div class="col-md-6 col-sm-6">
        <form action="#" method="post" class="sky-form boxed">

          <header class="size-18 margin-bottom-20">
            <i class="fa fa-users"></i> {{ trans('auth.social_signup') }}
          </header>

          <fieldset class="nomargin">

            <div class="row">

              <div class="col-md-8 col-md-offset-2">

                <a class="btn btn-block btn-social btn-facebook margin-bottom-10" href="/auth/facebook">
                    <i class="fa fa-facebook"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Facebook']) }}
                </a>

                <a class="btn btn-block btn-social btn-twitter margin-bottom-10" href="/auth/twitter">
                 <i class="fa fa-twitter"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Twitter']) }}
                </a>

                <a class="btn btn-block btn-social btn-google margin-bottom-10" href="/auth/google">
                  <i class="fa fa-google"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Google']) }}
                </a>

                <a class="btn btn-block btn-social btn-github margin-bottom-10" href="/auth/github">
                   <i class="fa fa-github"></i> {{ trans('auth.sign_in_with',  ['social_network' => 'Github']) }}
                </a>
              </div>
            </div>

          </fieldset>

          <footer>
            <!-- {!! trans('auth.already_have_account') !!} -->
          </footer>

        </form>

      </div>
      <!-- /SOCIAL LOGIN -->

    </div>


  </div>
</section>
<!-- / -->


<!-- MODAL -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModal">{{ trans('general.terms') }} &amp; {{ trans('general.conditions') }}</h4>
			</div> <!-- modal-header -->

			<div class="modal-body modal-short">
        <p>By signing up for the AnyShare service ("Service") or any of the services of AnyShare Society (“AnyShare”) you are agreeing to be bound by the following terms and conditions ("Terms of Service"). The Services offered by AnyShare under the Terms of Service include products and services to help you create and manage an online Share ("Online Services"). Any new features or tools which are added to the current Service shall be also subject to the Terms of Service.</p>

        <p>AnyShare reserves the right to update and change the Terms of Service by posting updates and changes to the AnyShare website. You are advised to check the Terms of Service from time to time for any updates or changes that may impact you.</p>

        <p>You must read, agree with and accept all of the terms and conditions contained in this Terms of Service agreement and AnyShare’s <a href="/privacy">Privacy Policy</a> before you may become an AnyShare user.</p>


        <h2>Account Terms</h2>
        <ol>
          <li>You must be 18 years or older or at least the age of majority in the jurisdiction where you reside or from which you use this Service.</li>

          <li>To access and use the Services, you must sign-up for a AnyShare account ("Account") by providing your full legal name, a valid email address, and any other information indicated as required. AnyShare may reject your application for an Account, or cancel an existing Account, for any reason, in our sole discretion.</li>

          <li>You acknowledge that AnyShare will use the email address you provide as the primary method for communication.</li>

          <li>You are responsible for keeping your password secure. AnyShare cannot and will not be liable for any loss or damage from your failure to maintain the security of your Account and password.</li>

          <li>You are responsible for all activity and content such as data, graphics, photos and links that is uploaded under your AnyShare Account ("Share Content"). You must not transmit any worms or viruses or any code of a destructive nature.</li>

          <li>A breach or violation of any term in the Terms of Service as determined in the sole discretion of AnyShare will result in an immediate termination of your services.</li>
        </ol>

        <h2>Account Activation</h2>
        <ol>
          <li>Subject to section 2.2, the person signing up for the Service will be the contracting party ("Account Owner") for the purposes of our Terms of Service and will be the person who is authorized to use any corresponding account we may provide to the Account Owner in connection with the Service.</li>
          <li>If you are signing up for the Service on behalf of your employer, your employer shall be the Account Owner. If you are signing up for the Service on behalf of your employer, then you represent and warrant that you have the authority to bind your employer to our Terms of Service.</li>
        </ol>

        <h2>General Conditions</h2>
        <p>You must read, agree with and accept all of the terms and conditions contained in these Terms of Service and the <a href="/privacy">Privacy Policy</a> before you may become a member of AnyShare.</p>
        <ol>
          <li>Technical support is only provided to paying Account holders and is only available via email.</li>
          <li>The Terms of Service shall be governed by and interpreted in accordance with the laws of the State of Delaware and the laws of USA applicable therein, without regard to principles of conflicts of laws. The parties irrevocably and unconditionally submit to the exclusive jurisdiction of the courts of the State of Delaware with respect to any dispute or claim arising out of or in connection with the Terms of Service. The United Nations Convention on Contracts for the International Sale of Goods will not apply to these Terms of Service and is hereby expressly excluded.</li>
          <li>You acknowledge and agree that AnyShare may amend these Terms of Service at any time by posting the relevant amended and restated Terms of Service on AnyShare’s website, available at <a href="/terms">terms</a> and such amendments to the Terms of Service are effective as of the date of posting. Your continued use of the Services after the amended Terms of Service are posted to AnyShare’s website constitutes your agreement to, and acceptance of, the amended Terms of Service. If you do not agree to any changes to the Terms of Service, do not continue to use the Service.</li>
          <li>You may not use the AnyShare service for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws), the laws applicable to you in your customer’s jurisdiction, or the laws of USA and the State of Delaware. You will comply with all applicable laws, rules and regulations in your use of the Service.</li>
          <li>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service without the express written permission by AnyShare.</li>
          <li>You shall not purchase search engine or other pay per click keywords (such as Google AdWords), or domain names that use AnyShare or AnyShare trademarks and/or variations and misspellings thereof.</li>
          <li>Questions about the Terms of Service should be sent to info@anysha.re</li>
          <li>You understand that your Share Content (not including credit card information), may be transferred unencrypted and involve (a) transmissions over various networks; and (b) changes to conform and adapt to technical requirements of connecting networks or devices. Credit Card information is always encrypted during transfer over networks.</li>
          <li>You acknowledge and agree that your use of the Service, including information transmitted to or stored by AnyShare, is governed by its privacy policy at <a href="/privacy">privacy</a></li>
          <li>The parties have required that the Terms of Service and all documents relating thereto be drawn up in English.</li>
        </ol>

        <h2>AnyShare Rights</h2>
        <ol>
          <li>We reserve the right to modify or terminate the Service for any reason, without notice at any time.</li>
          <li>We reserve the right to refuse service to anyone for any reason at any time.</li>
          <li>We may, but have no obligation to, remove Share Content and Accounts containing content that we determine in our sole discretion are unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms of Service.</li>
          <li>Verbal or written abuse of any kind (including threats of abuse or retribution) of any AnyShare customer, AnyShare employee, member, or officer will result in immediate Account termination.</li>
          <li>AnyShare does not pre-screen Share Content and it is in our sole discretion to refuse or remove any Share Content that is available via the Service.</li>
          <li>We reserve the right to provide our services to your competitors and make no promise of exclusivity in any particular market segment. You further acknowledge and agree that AnyShare employees and contractors may also be AnyShare customers/merchants and that they may compete with you, although they may not use your confidential information in doing so.</li>
          <li>In the event of a dispute regarding Account ownership, we reserve the right to request documentation to determine or confirm Account ownership. Documentation may include, but is not limited to, a scanned copy of your business license, government issued photo ID, the last four digits of the credit card on file, etc.</li>
          <li>AnyShare retains the right to determine, in our sole judgment, rightful Account ownership and transfer an Account to the rightful owner. If we are unable to reasonably determine the rightful Account owner, AnyShare reserves the right to temporarily disable an Account until resolution has been determined between the disputing parties.</li>
        </ol>

        <h2>Limitation of Liability</h2>
        <ol>
          <li>You expressly understand and agree that AnyShare shall not be liable for any direct, indirect, incidental, special, consequential or exemplary damages, including but not limited to, damages for loss of profits, goodwill, use, data or other intangible losses resulting from the use of or inability to use the service.</li>
          <li>You agree to indemnify, defend and hold AnyShare, its affiliates, subsidiaries, directors, officers, employees and suppliers (collectively "Indemnified Person(s)") harmless from and against any and all third party claims and any related liability, loss, and expense (including damage awards, settlement amounts, and reasonable legal fees), brought against any Indemnified Person(s), arising out of, related to or which may arise from Your breach of the terms and conditions of this Agreement or in relation to the Share or any business, activity or transactions carried out or performed on the Share.</li>
          <li>In no event shall AnyShare or our suppliers be liable for lost profits or any special, incidental or consequential damages arising out of or in connection with our site, our services or these Terms of Service (however arising including negligence). You agree to indemnify and hold the Indemnified Person(s) harmless from any claim or demand, including reasonable attorneys' fees, made by any third party due to or arising out of your breach of these Terms of Service or the documents it incorporates by reference, or your violation of any law or the rights of a third party.</li>
          <li>Your use of the Service is at your sole risk. The Service is provided on an "as is" and "as available" basis without any warranty or condition, express, implied or statutory.</li>
          <li>AnyShare does not warrant that the Service will be uninterrupted, timely, secure, or error-free.</li>
          <li>AnyShare does not warrant that the results that may be obtained from the use of the Service will be accurate or reliable.</li>
          <li>AnyShare does not warrant that the quality of any products, services, information, or other material purchased or obtained by you through the Service will meet your expectations, or that any errors in the Service will be corrected.</li>
        </ol>

        <h2>Waiver and Complete Agreement</h2>
        <p>The failure of AnyShare to exercise or enforce any right or provision of the Terms of Service shall not constitute a waiver of such right or provision. The Terms of Service constitutes the entire agreement between you and AnyShare and govern your use of the Service, superseding any prior agreements between you and AnyShare (including, but not limited to, any prior versions of the Terms of Service).</p>

        <h2>Intellectual Property and Customer Content</h2>
        <ol>
          <li>You retain any copyright that you may have in Your Content.</li>
          <li>You hereby agree that Your Content:
            <ol type="a">
              <li>is hereby licensed under the Creative Commons Attribution Non-Commercial 4.0 License and may be used under the terms of that license or any later version of a Creative Commons Attribution License, or </li>
              <li>is in the public domain (such as Content that is not copyrightable or Content you make available under CC0), or </li>
              <li>if not owned by you, (i) is available under a Creative Commons Attribution Non-Commercial 4.0 License or (ii) is a media file that is available under any Creative Commons license or that you are authorized by law to post or share through any of the Services, such as under the fair use doctrine, and that is prominently marked as being subject to third party copyright.</li>
            </ol>
          </li>
        </ol>

        <h2>Payment of Fees</h2>
        <ol>
          <li>AnyShare may charge You the mutually agreed fees for the use of the Service. If any fees are chargeable for the Service, they shall be charged from You monthly or at other mutually agreed intervals.</li>
          <li>Unless and to the extent expressly indicated otherwise, listed fees and any amounts payable are net amounts exclusive of possibly applicable sales tax, or any other applicable taxes and charges imposed by any government entity in connection with Your use of the Service. You are liable for any any such taxes and charges.</li>
          <li>If a payment is late from its due date, then AnyShare has the right to suspend the provision of the Service temporarily until the payment is made.</li>
          <li>AnyShare reserves the right to change pricing when needed. AnyShare shall notify You of a change in the fees charged for the Service at least 30 days in advance and You should wish not to accept the change in fees,</li>
          <li>AnyShare does not provide refunds.</li>
        </ol>

        <h2>Cancellation and Termination</h2>
        <ol>
          <li>You may cancel your Account at anytime by emailing support@anyha.re and then following the specific instructions indicated to you in AnyShare's response.</li>
          <li>Upon termination of the Services by either party for any reason:
            <ol type="a">
              <li>AnyShare will cease providing you with the Services and you will no longer be able to access your Account;</li>
              <li>unless otherwise provided in the Terms of Service, you will not be entitled to any refunds of any Fees, pro rata or otherwise;</li>
              <li>any outstanding balance owed to AnyShare for your use of the Services through the effective date of such termination will immediately become due and payable in full; and</li>
              <li>your Share will be taken offline.</li>
            </ol>
          </li>
          <li>If at the date of termination of the Service, there are any outstanding Fees owed by you, you will receive one final invoice via email. Once that invoice has been paid in full, you will not be charged again.</li>
          <li>We reserve the right to modify or terminate the AnyShare Service or your Account for any reason, without notice at any time.</li>
          <li>Fraud: Without limiting any other remedies, AnyShare may suspend or terminate your Account if we suspect that you (by conviction, settlement, insurance or escrow investigation, or otherwise) have engaged in fraudulent activity in connection with the Site.</li>
        </ol>

        <h2>Modifications to the Service and Prices</h2>
        <ol>
          <li>Prices for using the Services are subject to change upon 30 days notice from AnyShare. Such notice may be provided at any time by posting the changes to the AnyShare Site (anysha.re) or the administration menu of your AnyShare Share via an announcement.</li>
          <li>AnyShare reserves the right at any time, and from time to time, to modify or discontinue, the Service (or any part thereof) with or without notice.</li>
          <li>AnyShare shall not be liable to you or to any third party for any modification, price change, suspension or discontinuance of the Service.</li>
        </ol>

        <h2>Third Party Services</h2>
        <ol>
          <li>In addition to these Terms of Service, you also agree to be bound by the additional service-specific terms applicable to services you purchase from, or that are provided by, AnyShare's partners or other third parties.</li>
          <li>AnyShare may from time to time recommend, provide you with access to, or enable third party software, applications ("Apps"), products, services or website links (collectively, "Third Party Services") for your consideration or use. Such Third Party Services are made available only as a convenience, and your purchase, access or use of any such Third Party Services is solely between you and the applicable third party services provider ("Third Party Provider"). Any use by you of Third Party Services offered through the Services or AnyShare’s website is entirely at your own risk and discretion, and it is your responsibility to read the terms and conditions and/or privacy policies applicable to such Third Party Services before using them.</li>
          <li>We do not provide any warranties with respect to Third Party Services. You acknowledge that AnyShare has no control over Third Party Services, and shall not be responsible or liable to anyone for such Third Party Services. The availability of Third Party Services on AnyShare’s websites, or the integration or enabling of such Third Party Services with the Services does not constitute or imply an endorsement, authorization, sponsorship, or affiliation by or with AnyShare. AnyShare strongly recommends that you seek specialist advice before using or relying on Third Party Services, to ensure they will meet your needs. In particular, tax calculators should be used for reference only and not as a substitute for independent tax advice when assessing the correct tax rates you should charge to your customers.</li>
          <li>If you install or enable a Third Party Service for use with the Services, you grant us permission to allow the applicable Third Party Provider to access your data and to take any other actions as required for the interoperation of the Third Party Service with the Services, and any exchange of data or other interaction between you and the Third Party Provider is solely between you and such Third Party Provider. AnyShare is not responsible for any disclosure, modification or deletion of your data or Store Content, or for any corresponding losses or damages you may suffer, as a result of access by a Third Party Service or a Third Party Provider to your data or Store Content.</li>
          <li>Under no circumstances shall AnyShare be liable for any direct, indirect, incidental, special, consequential, punitive, extraordinary, exemplary or other damages whatsoever, that result from any Third Party Services or your contractual relationship with any Third Party Provider, including any Expert. These limitations shall apply even if AnyShare has been advised of the possibility of such damages. The foregoing limitations shall apply to the fullest extent permitted by applicable law.</li>
        </ol>

        <h2>DMCA Notice and Takedown Procedure</h2>
        <p>AnyShare supports the protection of intellectual property and asks AnyShare merchants to do the same. It's our policy to respond to all notices of alleged copyright infringement. If someone believes that one of our merchants is infringing their intellectual property rights, they can send a DMCA Notice to AnyShare's designated agent using our form. Upon receiving a DMCA Notice, we may remove or disable access to the material claimed to be a copyright infringement. Once provided with a notice of takedown, the merchant can reply with a counter notification using our form if they object to the complaint. The original complainant has 14 business days after we receive a counter notification to seek a court order restraining the merchant from engaging in the infringing activity, otherwise we restore the material. </p>
      </div><!-- /.modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="terms-agree"><i class="fa fa-check"></i> I Agree</button>

        <a href="page-print-terms.html" target="_blank" rel="nofollow" class="btn btn-danger pull-left">
          <i class="fa fa-print"></i><span class="hidden-xs"> Print</span>
        </a>
      </div> <!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- /MODAL -->

@stop
