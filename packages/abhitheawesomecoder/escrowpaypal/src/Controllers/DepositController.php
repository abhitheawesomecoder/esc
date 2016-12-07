<?php

namespace Abhitheawesomecoder\Escrowpaypal\Controllers;

//use Abhitheawesomecoder\Escrowpaypal\Models\Candidate;
use Abhitheawesomecoder\Escrowpaypal\Models\Paypal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\PaypalSettings;
use App\EscrowSettings;
use App\Transactions;
use App\UserBalance;
use Auth;
use Validator;


class DepositController extends Controller
{

  public function depositform(Request $request)
  {
    /*  var_dump($request->has('PayerID'));
      exit();*/
      if($request->has('token')){

        $token = $request->input('token');

        $payerid = $request->input('PayerID');

        $objpaypal = new PayPal();

        $paypalsetings = PaypalSettings::where('id','!=',0)->first()->toArray();

        $escrowsettings = EscrowSettings::where('id','!=',0)->first()->toArray();

        $paypalsetings['currency_code'] = $escrowsettings['currency_code'];

        $amount = session('amount',1);

        //echo $token;

        $return = $objpaypal->handlepaypalreturn($token,$payerid,$amount,$paypalsetings);

  // if($return['code']){

        $user_id = Auth::user()->id;

        $tran = new Transactions;
        $tran->user_id = $user_id;
        $tran->status = 1;
        $tran->gateway_name = "Paypal";
        $tran->amount = $amount;
        $tran->transation_id = $return['code'] ? $return["tranid"] : 'Pending' ;
        $tran->status = 1;
        $tran->type = "deposit";
        $tran->save();

        $tran = UserBalance::where('user_id',$user_id)->first();
        if($tran){
        }else{
          $tran = new UserBalance;
          $tran->user_id = $user_id;
        }
        $tran->main_balance = intval($tran->main_balance) + intval($amount);
        $tran->save();
// }
        return view('escrowpaypal::depositform',["success" => "Transation Successful"]);

      }

      return view('escrowpaypal::depositform');
  }
  public function savedeposit(Request $request)
  {
    $validator = Validator::make($request->all(), [
           'amount' => 'required|numeric'
       ]);

       if ($validator->fails()) {
         $url = null;
         $message = "Error. Please contact admin";
         $responsecode = 0;
         $resultarray = array("url" => $url, "msg" => $message, "code" => $responsecode);
         return json_encode($resultarray);
       }

    $objpaypal = new PayPal();

    $reason = "Deposit Money";

    $amount = $request->input('amount');

    session(['amount' => $amount]);

    $url = $request->input('url');

    $paypalsetings = PaypalSettings::where('id','!=',0)->first()->toArray();

    $escrowsettings = EscrowSettings::where('id','!=',0)->first()->toArray();

    $paypalsetings['currency_code'] = $escrowsettings['currency_code'];

		$ret = $objpaypal->makepaymentwithpaypal($reason,$amount,$url,$paypalsetings);

    return $ret;
  }

}
