@extends('layouts/home-frontend-master')

@section('content')

<div class="main-container"><section class="page-title page-title-center ">
							<div class="container"><div class="row"><div class="col-sm-12 text-center">
					        	<h1 class="heading-title mb0">Contact Us</h1>
					        	<p class="lead fade-color mb0"></p>
							</div></div></div><ol class="breadcrumb breadcrumb-style"><li><a href="{{route('home')}}" class="home-link" rel="home">Home</a></li><li class="active">Contact Us</li></ol></section><div class="tlg-page-wrapper">
	<a id="home" href="#"></a>
	<section class="vc_row wpb_row vc_row-fluid bg-light not-equal not-color"><div class=" container "><div class="row "><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div role="form" class="wpcf7" id="wpcf7-f251-p111-o1" lang="en-US" dir="ltr">
<div class="screen-reader-response"></div>
<form action="http://sharing.space/contact/#wpcf7-f251-p111-o1" method="post" class="wpcf7-form" novalidate="novalidate">
<div style="display: none;">
<input type="hidden" name="_wpcf7" value="251" />
<input type="hidden" name="_wpcf7_version" value="5.0.5" />
<input type="hidden" name="_wpcf7_locale" value="en_US" />
<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f251-p111-o1" />
<input type="hidden" name="_wpcf7_container_post" value="111" />
</div>
<p><label> Your Name (required)<br />
    <span class="wpcf7-form-control-wrap your-name"><input type="text" name="your-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" /></span> </label></p>
<p><label> Your Email (required)<br />
    <span class="wpcf7-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false" /></span> </label></p>
<p><label> Subject<br />
    <span class="wpcf7-form-control-wrap your-subject"><input type="text" name="your-subject" value="" size="40" class="wpcf7-form-control wpcf7-text" aria-invalid="false" /></span> </label></p>
<p><label> Your Message<br />
    <span class="wpcf7-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false"></textarea></span> </label></p>
<p><input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit" /></p>
<div class="wpcf7-response-output wpcf7-display-none"></div></form></div></div></div></div></div></div></section>
</div>
@endsection