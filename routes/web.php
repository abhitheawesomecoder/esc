<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
/*
//change packages to vendor
  $path = public_path('../packages/abhitheawesomecoder');

  var_dump(file_exists($path));
  foreach (scandir($path)as $key => $value) {
    if((strpos($value, 'escrow') !== false)&&(strlen($value) > 6)){

      var_dump(str_replace("escrow","",$value));
    }
  }

  exit();*/
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
