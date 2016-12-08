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
use App\WithdrawlRequest;

class WithdrawlController extends Controller
{

  public function withdrawlform()
  {
    return view("escrowpaypal::withdrawlform")
  }

  public function savewithdrawlrequest()
  {

  }

}
