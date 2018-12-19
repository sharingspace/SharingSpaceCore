
<?php

Route::get('/home','PageController@viewHomePage')->name('frontend.home');
Route::get('/home/{slug}','PageController@viewSlugPage')->name('frontend.slug');
Route::get('admin/control/dashboard','PageController@dashboard')->name('frontend.admin.dashboard');

Route::get('admin/control/pages','PageController@adminControl')->name('frontend.admin.control');
Route::get('admin/control/page/create','PageController@adminControlCreate')->name('frontend.admin.control.page.create');
Route::post('admin/control/page/post','PageController@adminControlPost')->name('frontend.admin.control.post');
Route::get('admin/control/page/edit/{id}','PageController@getControlEdit')->name('frontend.get.control.edit');
Route::post('admin/control/page/update','PageController@postControlEdit')->name('frontend.post.control.edit');
Route::get('admin/control/page/delete/{id}','PageController@getControlDelete')->name('frontend.get.control.delete');

Route::get('admin/control/menus','PageController@indexMenu')->name('frontend.admin.menu');
Route::get('admin/control/menu/create','PageController@createMenu')->name('frontend.admin.control.menu.create');
Route::post('admin/control/menu/post','PageController@postMenu')->name('frontend.admin.control.menu.post');
Route::get('admin/control/menu/edit/{id}','PageController@editMenu')->name('frontend.get.control.menu.edit');
Route::post('admin/control/menu/update','PageController@updateMenu')->name('frontend.post.control.menu.update');
Route::get('admin/control/menu/delete/{id}','PageController@deleteMenu')->name('frontend.get.control.menu.delete');