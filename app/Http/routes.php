<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* -------------------S:buat cron----------------------------------- */
Route::get('cron/schedule', 'CronController@schedule');

Route::get('cron/tagging/{id_microsite}', 'CronController@tagging');

Route::get('cron/sitemap/{id_microsite}', 'CronController@sitemap');
/* -------------------E:buat cron----------------------------------- */


/* -------------------S:halaman welcome----------------------------------- */
Route::get('/', 'WelcomeController@index');
/* -------------------E:halaman welcome----------------------------------- */


/* -------------------S:halaman forbidden----------------------------------- */
Route::get('forbidden', 'ForbiddenController@index');
/* -------------------E:halaman forbidden----------------------------------- */

/* -------------------S:halaman Home----------------------------------- */
//halaman utama
Route::get('home', 'HomeController@index');

//create microsite
Route::get('home/create_microsite', 'HomeController@create_microsite');

//do save microsite
Route::post('home/do_save_microsite', 'HomeController@do_save_microsite');

//do change microsite
Route::post('home/do_changemicrosite', 'HomeController@do_changemicrosite');
/* -------------------E:halaman Home----------------------------------- */


/* -------------------S:halaman Group_User----------------------------------- */
/* buat group_users 
Route::resource('group_user','Group_userController');
*/

//halaman utama
Route::get('group_user', 'Group_userController@index');

//list group_users
Route::get('group_user/getBasicData', 'Group_userController@getBasicData');

//create group_users
Route::get('group_user/create', 'Group_userController@create');

//store groupp user
Route::post('group_user/store', 'Group_userController@store');

//edit group_users
Route::get('group_user/edit/{id}', 'Group_userController@edit');

//post update groupp user
Route::post('group_user/update', 'Group_userController@update');

//post destroy groupp user
Route::post('group_user/destroy', 'Group_userController@destroy');
/* -------------------E:halaman Group_User----------------------------------- */


/* -------------------S:halaman User----------------------------------- */
//halaman utama
Route::get('user', 'UserController@index');

//list user
Route::get('user/getBasicData', 'UserController@getBasicData');

//create user
Route::get('user/create', 'UserController@create');

//store user 
Route::post('user/store', 'UserController@store');

//edit user
Route::get('user/edit/{id}', 'UserController@edit');

//post update  user
Route::post('user/update', 'UserController@update');

//post destroy  user
Route::post('user/destroy', 'UserController@destroy');
/* -------------------E:halaman User----------------------------------- */


/* -------------------S:halaman Manajemen Image----------------------------------- */
//halaman utama
Route::get('manajemen_image', 'Manajemen_imageController@index');

//list image
Route::get('manajemen_image/getBasicData', 'Manajemen_imageController@getBasicData');

//store image 
Route::post('manajemen_image/store', 'Manajemen_imageController@store');

//post destroy  image
Route::post('manajemen_image/destroy', 'Manajemen_imageController@destroy');
/* -------------------E:halaman Manajemen Image----------------------------------- */


/* -------------------S:halaman video----------------------------------- */
//halaman utama
Route::get('video_gallery', 'Video_galleryController@index');

//post insert video
Route::post('video_gallery/store', 'Video_galleryController@store');

//post delete video
Route::post('video_gallery/destroy', 'Video_galleryController@destroy');

/* -------------------E:halaman video----------------------------------- */


/* -------------------S:halaman image----------------------------------- */
//halaman utama
Route::get('image_gallery', 'Img_galleryController@index');

//list image album
Route::get('image_gallery/getBasicData', 'Img_galleryController@getBasicData');

//create image album
Route::get('image_gallery/create', 'Img_galleryController@create');

//store image album
Route::post('image_gallery/store', 'Img_galleryController@store');

//edit image
Route::get('image_gallery/edit/{id}', 'Img_galleryController@edit');

//post update  image
Route::post('image_gallery/update', 'Img_galleryController@update');

//post destroy image
Route::post('image_gallery/destroy', 'Img_galleryController@destroy');

/* -------------------E:halaman image----------------------------------- */


/* -------------------S:image manager----------------------------------- */
Route::get('image_manager', 'Image_managerController@index');
Route::get('image_manager/upload_image', 'Image_managerController@upload_image');

//store image manager
Route::post('image_manager/store', 'Image_managerController@store');

Route::post('image_manager/page/{id}', 'Image_managerController@page');
/* -------------------E:image manager----------------------------------- */


/* -------------------S:category article----------------------------------- */
Route::get('category_article', 'Category_articleController@index');

//list category article
Route::get('category_article/getBasicData', 'Category_articleController@getBasicData');

//create category article
Route::get('category_article/create', 'Category_articleController@create');

//store category article
Route::post('category_article/store', 'Category_articleController@store');

//edit category article
Route::get('category_article/edit/{id}', 'Category_articleController@edit');

//post update category article
Route::post('category_article/update', 'Category_articleController@update');

//post destroy category article
Route::post('category_article/destroy', 'Category_articleController@destroy');
/* -------------------E:category article----------------------------------- */


/* -------------------S:article----------------------------------- */
Route::get('article', 'ArticleController@index');

//list  article
Route::get('article/getBasicData', 'ArticleController@getBasicData');

//create  article
Route::get('article/create', 'ArticleController@create');

//store  article
Route::post('article/store', 'ArticleController@store');

//edit  article
Route::get('article/edit/{id}', 'ArticleController@edit');

//post update  article
Route::post('article/update', 'ArticleController@update');

//post destroy  article
Route::post('article/destroy', 'ArticleController@destroy');
/* -------------------E:article----------------------------------- */

/* -------------------S:profile----------------------------------- */
Route::get('profile_setting', 'ProfileController@index');

//do change
Route::post('profile_setting/store', 'ProfileController@store');
/* -------------------S:profile----------------------------------- */


/* -------------------S:profile settting----------------------------------- */
Route::get('frontpage_setting', 'Frontpage_setting@index');

Route::post('frontpage_setting/do_upload', 'Frontpage_setting@do_upload');

Route::post('frontpage_setting/popup', 'Frontpage_setting@popup');

Route::get('frontpage_setting/getBasicData', 'Frontpage_setting@getBasicData');

Route::post('frontpage_setting/store', 'Frontpage_setting@store');

/* -------------------S:profile settting----------------------------------- */


/* -------------------S:editor choice----------------------------------- */
Route::get('article_editor', 'Article_editorController@index');

Route::post('article_editor/popup', 'Article_editorController@popup');

Route::get('article_editor/getBasicData', 'Article_editorController@getBasicData');

Route::post('article_editor/store', 'Article_editorController@store');
/* -------------------E:editor choice----------------------------------- */

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
