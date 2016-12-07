<?php

namespace Abhitheawesomecoder\Escrow\Controllers;

//use Abhitheawesomecoder\Escrowpaypal\Models\Candidate;
//use Abhitheawesomecoder\Escrow\Models\Job;
use App\Http\Controllers\Controller;
use App\EscrowSettings;
use App\Transfers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;
use App\UserBalance;

class TransferController extends Controller
{

  public function transferform()
  {
      $escrowsettings = EscrowSettings::where('id','!=',0)->first();
      return view('escrow::transferform',['escrowsettings' => $escrowsettings]);
  }

  public function savetransfer(Request $request)
  {
        $this->validate($request, [
        'email' => 'required|email',
        'amount' => 'required|numeric',
        'amount_received' => 'required|numeric',
        'description' => 'required|max:255'
    ]);

    $user_id = Auth::user()->id;

    $usercheck = User::where('email',$request->input('email'))->first();

    if($usercheck){

    }else{

    $usercheck = User::create([
          'name' => $request['name'],
          'email' => $request['email'],
          'password' => bcrypt("escrowpassword"),
      ]);

    }

    $transfers = new Transfers;
    $transfers->user_id = $user_id;
    $transfers->receiverid = $usercheck->id;
    $transfers->amount = $request->input('amount');
    $transfers->description = $request->input('description');
    $Transfers->save();

    $userbalsender = UserBalance::where('user_id',$user_id)->first();

    $userbalrec = UserBalance::where('user_id',$usercheck->id)->first();

    if($userbalsender){
    }else{
      $userbalsender = new UserBalance;
    }

      $sendermainbal = $userbalsender->main_balance;

      $senderescrowbal = $userbalsender->escrow_balance;

    if($userbalrec){
    }else{
      $userbalrec = new UserBalance;
    }

      $recmainbal = $userbalrec->main_balance;

      $recescrowbal = $userbalrec->escrow_balance;



      if(int($sendermainbal) > int($amount))
      {
        $sendermainbal = $sendermainbal - $amount;

        $senderescrowbal = $senderescrowbal + $amount;

        $userbalsender->main_balance = $sendermainbal;

        $userbalsender->escrow_balance = $senderescrowbal;

        $recescrowbal = $recescrowbal + $amount;

        $userbalrec->escrow_balance = $recescrowbal;

        $userbalsender->save();

        $userbalrec->save();

        $escrowsettings = EscrowSettings::where('id','!=',0)->first()->toArray();

        $message = "You have received ".$request->input('amount')." ".$escrowsettings['currency_code']." from ".Auth::user()->name.". Please Login to withdraw your Money. ".url('login');

        \Mail::raw('Text to e-mail', function ($message) use ($request) {

           $message->from(Auth::user()->email, Auth::user()->name);

           $message->to($request->input('email'), $request->input('name'))->subject('Money Received');
        });

      }


    // check if user email in db
    // if yes then save details and send mail
    // if not then register user and send mail
    //  return User::create([ 'name' => $data['name'], 'email' => $data['email'], 'password' => bcrypt($data['password']), ]);

/*
    $transfer = new Transfers;
    $transfer->senderid = $user_id;
    $transfer->recid = $rec_id;
    $transfer->amount = $amount;
    $transfer->description = $desc;
    $result = $transfer->save();
*/
    //use App\UserBalance;


    return redirect()->back();
  }

}
