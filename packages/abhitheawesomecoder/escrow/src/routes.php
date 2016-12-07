<?php
/*
Route::get('/test', function () {
    return view('welcome');
});*/
Route::group(['middleware' => ['web','auth']], function () {

  Route::get('/escrow/transfer', 'abhitheawesomecoder\escrow\controllers\TransferController@transferform');
  Route::post('/escrow/transfer', 'abhitheawesomecoder\escrow\controllers\TransferController@savetransfer');
});
