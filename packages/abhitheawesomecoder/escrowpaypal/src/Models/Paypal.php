<?php
namespace Abhitheawesomecoder\Escrowpaypal\Models;

/* class to handel transfer amount to paypal of admin */
class PayPal {

	private function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode) {
			// Set up your API credentials, PayPal end point, and API version.
			$API_UserName = urlencode($PayPalApiUsername);
			$API_Password = urlencode($PayPalApiPassword);
			$API_Signature = urlencode($PayPalApiSignature);

			if($PayPalMode=='sandbox')
			{
				$paypalmode 	=	'.sandbox';
			}
			else
			{
				$paypalmode 	=	'';
			}

			$API_Endpoint = "https://api-3t".$paypalmode.".paypal.com/nvp";
			$version = urlencode('76.0');

			// Set the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);

			// Turn off the server and peer verification (TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);

			// Set the API operation, version, and API signature in the request.
			$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

			// Set the request as a POST FIELD for curl.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

			// Get response from the server.
			$httpResponse = curl_exec($ch);

			if(!$httpResponse) {
				exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
			}

			// Extract the response details.
			$httpResponseAr = explode("&", $httpResponse);

			$httpParsedResponseAr = array();
			foreach ($httpResponseAr as $i => $value) {
				$tmpAr = explode("=", $value);
				if(sizeof($tmpAr) > 1) {
					$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
				}
			}

			if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
				exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
			}

		return $httpParsedResponseAr;
	}


	public  function makepaymentwithpaypal($reason,$amount,$url,$paypaldetails){

	//Mainly we need 4 variables from an item, Item Name, Item Price, Item Number and Item Quantity.

	$ItemName = $reason; //Item Name

	$ItemPrice = $amount; //Item Price

	$ItemNumber = rand(1000, 9999);;

	$ItemQty = 1;

	$ItemTotalPrice = ($ItemPrice*$ItemQty); //(Item Price x Quantity = Total) Get total amount of product;

	$PayPalCurrencyCode = $paypaldetails["currency_code"];

	$PayPalReturnURL = $url;

	$PayPalCancelURL = $url;

	$PayPalApiUsername = $paypaldetails["paypal_api_username"];

    $PayPalApiPassword	= $paypaldetails["paypal_api_password"];

	$PayPalApiSignature = $paypaldetails["paypal_api_signature"];

	$PayPalMode = $paypaldetails["paypal_mode"];

	//Data to be sent to paypal

	$padata = 	'&CURRENCYCODE='.urlencode($PayPalCurrencyCode).

				'&PAYMENTACTION=Sale'.

				'&ALLOWNOTE=1'.

				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).

				'&PAYMENTREQUEST_0_AMT='.urlencode($ItemTotalPrice).

				'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).

				'&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).

				'&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).

				'&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).

				'&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemNumber).

				'&AMT='.urlencode($ItemTotalPrice).

				'&RETURNURL='.urlencode($PayPalReturnURL ).

				'&CANCELURL='.urlencode($PayPalCancelURL);



	//We need to execute the "SetExpressCheckOut" method to obtain paypal token



		$httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

		//return json_encode($httpParsedResponseAr);

		//Respond according to message we receive from Paypal

		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){


				// If successful set some session variable we need later when user is redirected back to page from paypal.

				/*$segment->set('itemprice',$ItemPrice);

				$segment->set('totalamount',$ItemTotalPrice);

				$segment->set('itemName',$ItemName);

				$segment->set('itemNo',$ItemNumber);

				$segment->set('itemQTY',$ItemQty);

				$segment->set('tac_rec',$Reciever);

				$segment->set('tac_sender',$Sender);*/
/*
				\Session::put("amount", $ItemTotalPrice);

				\Session::put("requestid","paypal-d");

				\Session::put("extid","paypal");

				\Session::put("url",$url);
*/
				if($PayPalMode=='sandbox')

				{

					$paypalmode 	=	'.sandbox';

				}

				else

				{

					$paypalmode 	=	'';

				}

				//Redirect user to PayPal store with Token received.

			 	$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';

				//echo "<script>window.location='".$paypalurl."'</script>";

				//header('Location: '.$paypalurl);

				$url = $paypalurl;

				$message = "Success. Now redirecting to Paypal";

				$responsecode = 2;


			    $resultarray = array("url" => $url, "msg" => $message, "code" => $responsecode);

			    return json_encode($resultarray);

		}else{

			//Show error message
/*
			$debug = $segment->get("debug");

			if($debug == "off"){

				$status[0] = 0;

				$status[1] = "Error: Transation Terminated. Please contact admin.";

				return $status;

			}else{

				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';

				echo '<pre>';

				print_r($httpParsedResponseAr);

				echo '</pre>';



			}*/

			    $url = null;

				$message = "Error. Please contact admin";

				$responsecode = 0;


			    $resultarray = array("url" => $url, "msg" => $message, "code" => $responsecode);

			    return json_encode($resultarray);

		}



}



function handlepaypalreturn($token,$payerid,$amount,$paypaldetails){

	$PayPalMode = $paypaldetails["paypal_mode"];

	$PayPalCurrencyCode = $paypaldetails["currency_code"];

	$PayPalApiUsername = $paypaldetails["paypal_api_username"];

  $PayPalApiPassword	= $paypaldetails["paypal_api_password"];

	$PayPalApiSignature = $paypaldetails["paypal_api_signature"];



	//get session variables

	$ItemTotalPrice = $amount;


	$padata = 	'&TOKEN='.urlencode($token).

						'&PAYERID='.urlencode($payerid).

						'&PAYMENTACTION='.urlencode("SALE").

						'&AMT='.urlencode($ItemTotalPrice).

						'&CURRENCYCODE='.urlencode($PayPalCurrencyCode);



	//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.



	$httpParsedResponseAr = $this->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
/*
var_dump($padata);
echo "<br>";
var_dump($PayPalApiUsername);
echo "<br>";
var_dump($PayPalApiPassword);
echo "<br>";
var_dump($PayPalApiSignature);
echo "<br>";
var_dump($PayPalMode);
echo "<br>";
var_dump($httpParsedResponseAr);
exit();
*/
	//Check if everything went ok..

	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){


		$tranID = urldecode($httpParsedResponseAr["TRANSACTIONID"]);



			//echo '<h2>Success</h2>';

			//echo 'Your Transaction ID :'.urldecode($httpParsedResponseAr["TRANSACTIONID"]);

			  /*

				//Sometimes Payment are kept pending even when transaction is complete.

				//May be because of Currency change, or user choose to review each payment etc.

				//hence we need to notify user about it and ask him manually approve the transiction

				*/


				if('Completed' == $httpParsedResponseAr["PAYMENTSTATUS"])

				{

					//echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';

					//echo '<div style="color:green">Payment Received!</div>';

				$message = "Payment Received!";

				$responsecode = 1;

			    $resultarray = array("tranid" => $tranID, "msg" => $message, "code" => $responsecode, "amount" => $amount);

			    return $resultarray;


				}

				elseif('Pending' == $httpParsedResponseAr["PAYMENTSTATUS"])

				{

					//echo '<div style="color:red">Transaction Complete, but payment is still pending! You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';

					$message = "Transaction Complete, but payment is still pending! You need to manually authorize this payment in your Paypal Account";

					$responsecode = 1;

				    $resultarray = array("tranid" => $tranID, "msg" => $message, "code" => $responsecode, "amount" => $amount);

				    return $resultarray;

				}









	}else{



						/*echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';

						echo '<pre>';

						print_r($httpParsedResponseAr);

						echo '</pre>';*/

					$message = urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);

					$responsecode = 0;

				    $resultarray = array("msg" => $message, "code" => $responsecode);

				    return $resultarray;



	}





}

}
