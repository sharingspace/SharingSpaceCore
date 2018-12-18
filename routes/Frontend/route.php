
<?php

Route::get('/home','PageController@viewHomePage')->name('frontend.home');
Route::get('admin/controls','PageController@adminControlIndex')->name('frontend.admin.control.list');
Route::get('admin/control','PageController@adminControl')->name('frontend.admin.control');
Route::post('admin/control/post','PageController@adminControlPost')->name('frontend.admin.control.post');
Route::get('admin/control/edit/{id}','PageController@getControlEdit')->name('frontend.get.control.edit');
Route::post('admin/control/update','PageController@postControlEdit')->name('frontend.post.control.edit');
Route::get('admin/control/delete/{id}','PageController@getControlDelete')->name('frontend.get.control.delete');
