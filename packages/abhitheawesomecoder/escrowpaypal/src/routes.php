<?php
/*
Route::get('/escrow/paypal/deposit', function () {
    return view('welcome');
});*/
Route::group(['middleware' => ['web','auth']], function () {

  Route::get('/escrow/deposit/paypal', 'abhitheawesomecoder\escrowpaypal\controllers\DepositController@depositform');

  Route::post('/escrow/deposit/paypal', 'abhitheawesomecoder\escrowpaypal\controllers\DepositController@savedeposit');

  Route::get('/escrow/withdraw/paypal', 'abhitheawesomecoder\escrowpaypal\controllers\WithdrawController@withdrawform');

  Route::post('/escrow/withdraw/paypal', 'abhitheawesomecoder\escrowpaypal\controllers\WithdrawController@savewithdrawlrequest');


});
