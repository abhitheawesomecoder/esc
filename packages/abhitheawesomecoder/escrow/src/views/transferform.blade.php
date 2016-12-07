@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(function() {

    var minimum_value = 1.35;

    // cache elements that are used at least twice
    var $amount = $("#amount"),
        $msg = $("#message"),
        $commission = $("#amount_received");
        commper = $("#commission").val();
        if(commper == 0)
            commper = 1;
        else
            commper = commper / 100;
    // attach handler to input keydown event
    $amount.keyup(function(e){

        if (e.which == 13) {
            return;
        }
        var amount = parseFloat($amount.val());

        commission = amount* commper;

        if (isNaN(commission) || isNaN(amount)) {
            $msg.hide();
            $commission.hide();
            return;
        }

        if (amount <= minimum_value) {
            $commission.hide();
            $msg
                .text("Minimum amount should be more than "+amount)
                .fadeIn();
        } else {
            $msg.hide();

            $commission
             .fadeIn()
             .val(parseInt(((amount-commission))));
        }
    });
});
/*
$( document ).ready(function() {



  $( "#target" ).submit(function( event ) {
    event.preventDefault();
    $("#message").css('color', 'green');
    $("#message").html("Verifying please wait.....");
    $.post($("#target").attr('action'), $('#target').serialize(), function( data ) {
      if(data.code == 2){
        $("#message").html("Now redirecting to Paypal");
        window.location.href = data.url;
      }else{
        $("#message").css('color', 'red');
        $("#message").html("Error occured");
      }
      console.log(data);
}, "json");


  });

});*/
</script>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Make Payment</div>
                <div class="panel-body">
                    <form id="target" class="form-horizontal" role="form" method="POST" action="{{ url('escrow/transfer') }}">
                        {{ csrf_field() }}
                        <div id="message" style="text-align:center;margin-bottom:10px;color:green;">{{ $success or '' }}</div>

                        <input type="hidden" id="commission" value="{{ $escrowsettings->escrow_commission }}">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}" required autofocus>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('amount_received') ? ' has-error' : '' }}">
                            <label for="amount_received" class="col-md-4 control-label">Amount Received</label>

                            <div class="col-md-6">
                                <input id="amount_received" type="text" class="form-control" name="amount_received" value="{{ old('amount_received') }}" required autofocus>

                                @if ($errors->has('amount_received'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount_received') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Make Payment
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
