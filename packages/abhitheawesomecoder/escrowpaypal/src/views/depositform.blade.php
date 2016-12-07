@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
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

});
</script>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Make Payment</div>
                <div class="panel-body">
                    <form id="target" class="form-horizontal" role="form" method="POST" action="{{ url('escrow/deposit/paypal') }}">
                        {{ csrf_field() }}
                        <div id="message" style="text-align:center;margin-bottom:10px;color:green;">{{ $success or '' }}</div>

                        <input type="hidden" name="url" value="{{ url('escrow/deposit/paypal') }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}" required autofocus>

                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
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
