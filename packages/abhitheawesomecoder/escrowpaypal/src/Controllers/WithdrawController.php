<?php

namespace Abhitheawesomecoder\Escrowpaypal\Controllers;

//use Abhitheawesomecoder\Escrowpaypal\Models\Candidate;
//use Abhitheawesomecoder\Escrowpaypal\Models\Job;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;
use App\WithdrawlRequest;
use App\UserBalance;

class WithdrawController extends Controller
{

  public function withdrawform()
  {

    return view('escrowpaypal::withdrawlform');
  }

  public function savewithdrawlrequest(Request $request){

    $this->validate($request, [
        'amount' => 'required|numeric',
        'paypalid' => 'required|email'
    ]);

    $amount = $request->input("amount");
    $message = "Withdrawl request successful";
    $code = 1;
    $user_id = Auth::user()->id;

    $userbal = UserBalance::where("user_id",$user_id)->first();

    if($userbal){
      if(intval($userbal)-5 > $amount){

        $withdrawlrequest = new WithdrawlRequest;
        $withdrawlrequest->gateway_name = "paypal";
        $withdrawlrequest->user_id = $user_id;
        $withdrawlrequest->amount = $amount;
        $withdrawlrequest->save();

      }else{
        $message = "Insufficient balance";
        $code = 0;
      }
    }else{
      $message = "Insufficient balance";
      $code = 0;
    }



    return view('escrowpaypal::withdrawlform',["message"=> $message, "code" => $code ]);
  }

}
