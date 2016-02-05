@extends('layouts.master')
<style>

.about-section-2 {
  height: 350px;
  margin-bottom: 0px;
  background-color: #000;
  background-image: url("http://uploads.webflow.com/564b3e094801fab237b6b158/564d780e5e1ff0f11ea54aba_sitting.jpg");
  background-position: 50% 0px;
  background-size: contain;
  background-repeat: no-repeat;
}

.about-section-3 {
  margin-top: 0px;
  margin-bottom: 0px;
  padding-top: 43px;
  padding-bottom: 50px;
  background-color: transparent;
}

p {
  font-family: Montserrat, sans-serif;
  color: #636363;
  font-size: 15px;
}

#team_slider {
  position: relative;
  overflow: hidden;
  margin: 20px 0 0 0;
}

#team_slider ul {
  position: relative;
  margin: 0;
  padding: 0;
  list-style: none;
}

#team_slider ul li {
  position: relative;
  display: block;
  float: left;
  margin: 0;
  padding: 0;
  max-height: 366px;
  max-width: 550px;
  text-align: center;
  background-repeat: no-repeat;
  height: 100%;
  width: 100%;
  background-size:contain;
}

ul li span {
    display:table-cell;
    vertical-align: bottom;
    height: 366px;
    width: 550px;
    color:white;
    font-size: 24px;
}

a.control_prev, a.control_next {
  position: absolute;
  top: 40%;
  z-index: 999;
  display: block;
  padding: 4% 3%;
  width: auto;
  height: auto;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 18px;
  opacity: 0.8;
  cursor: pointer;
}

a.control_prev:hover, a.control_next:hover {
  opacity: 1;
  -webkit-transition: all 0.2s ease;
}

a.control_prev {
  border-radius: 0 2px 2px 0;
}

a.control_next {
  right: 0;
  border-radius: 2px 0 0 2px;
}

.slider_option {
  position: relative;
  margin: 10px auto;
  width: 160px;
  font-size: 18px;
}

</style>
@section('content')


<section id='slider' style="width:100%;">					
  <div style="background-color:rgba(0, 0, 0, 0.45);background-image: url('assets/img/backgrounds/nepal_tech.jpg'); height:400px;width:100%;background-position: 50% 0px;background-size: cover;background-repeat: no-repeat;">
    <h1>The Complete COOP</h1>
    <h2 style="text-align:center;">AnyShare brings a new business structure to the US.
</h2>
    <div style="text-align:center;"><a href="#" class="btn btn-danger">Try</a>
    <a href="#about" class="btn btn-warning w-button slider-buttons button-variation">Learn</a></div>
  </div>
</section>



<script>

jQuery(document).ready(function ($) {

  setInterval(function () {
      moveRight();
  }, 3000);
  
	var slideCount = $('#team_slider ul li').length;
	var slideWidth = $('#team_slider ul li').width();
	var slideHeight = $('#team_slider ul li').height();
	var sliderUlWidth = slideCount * slideWidth;
	
	$('#team_slider').css({ width: slideWidth, height: slideHeight });
	
	$('#team_slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	
    $('#team_slider ul li:last-child').prependTo('#team_slider ul');

    function moveLeft() {
        $('#team_slider ul').animate({
            left: + slideWidth
        }, 200, function () {
            $('#team_slider ul li:last-child').prependTo('#team_slider ul');
            $('#team_slider ul').css('left', '');
        });
    };

    function moveRight() {
        $('#team_slider ul').animate({
            left: - slideWidth
        }, 200, function () {
            $('#team_slider ul li:first-child').appendTo('#team_slider ul');
            $('#team_slider ul').css('left', '');
        });
    };

    $('a.control_prev').click(function (e) {
    e.preventDefault();
        moveLeft();
    });

    $('a.control_next').click(function (e) {
      e.preventDefault();
      moveRight();
    });
});

</script>
@stop
