@if ($errors->any())
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error:</strong> Please check the form below for errors
</div> <!-- alert -->
@endif

@if ($message = Session::get('success'))
<div class="col-md-12">
  <div class="alert alert-success alert-dismissable">
  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
 	 	<i class="fa fa-check"></i>
  	<strong>Success:</strong> {{ $message }}
  </div> <!-- alert -->
</div> <!-- col-md-12 -->
@endif

@if ($message = Session::get('error'))
<div class="col-md-12">
  <div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <i class="fa fa-exclamation-circle"></i>
    <strong>Error: </strong>
    {{ $message }}
  </div> <!-- alert -->
</div> <!-- col-md-12 -->

@endif

@if ($message = Session::get('warning'))
<div class="col-md-12">
  <div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="fa fa-exclamation-triangle"></i>  {{ $message }}
  </div> <!-- alert -->
</div> <!-- col-md-12 -->
@endif

@if ($message = Session::get('info'))
<div class="col-md-12">
  <div class="alert alert-info alert-dismissable">
  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  	<i class="fa fa-info-circle"></i> {{ $message }}
  </div> <!-- alert -->
</div> <!-- col-md-12 -->
@endif

@if ($message = Session::get('alert-no-fade'))
<div class="col-md-12">
	<div class="alert-no-fade alert-warning" role="alert">
		<i class="fa fa-info-circle"></i> {{ $message }}
	</div>
</div> <!-- col-md-12 -->
@endif

@if ($message = Session::get('success-no-fade'))
<div class="col-md-12">
	<div class="alert-no-fade alert-success alert-dismissable" role="alert">
		<i class="fa fa-check"></i> {{ $message }}
	</div>
</div> <!-- col-md-12 -->
@endif

@if ($message = Session::get('error-no-fade'))
<div class="col-md-12">
	<div class="alert-no-fade alert-danger alert-dismissable" role="alert">
		 <i class="fa fa-exclamation-circle"></i> {{ $message }}
	</div>
</div> <!-- col-md-12 -->
@endif
