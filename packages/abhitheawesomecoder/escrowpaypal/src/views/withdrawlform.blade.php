@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Withdraw Amount</div>
                <div class="panel-body">
                    <form id="target" class="form-horizontal" role="form" method="POST" action="{{ url('escrow/withdraw/paypal') }}">
                        {{ csrf_field() }}

                        <div id="message" style="text-align:center;margin-bottom:10px;color:green;">{{ $message or '' }}</div>

                        <input type="hidden" name="url" value="{{ url('escrow/withdraw/paypal') }}">

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

                        <div class="form-group{{ $errors->has('paypalid') ? ' has-error' : '' }}">
                            <label for="paypalid" class="col-md-4 control-label">Paypal Id</label>

                            <div class="col-md-6">
                                <input id="paypalid" type="text" class="form-control" name="paypalid" value="{{ old('paypalid') }}" required autofocus>

                                @if ($errors->has('paypalid'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paypalid') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>




                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Withdraw
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
