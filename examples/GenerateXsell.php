<?php
/*
 * Copyright notice:
 * (c) Copyright 2018 RocketGate
 * All rights reserved.
 *
 * The copyright notice must not be removed without specific, prior
 * written permission from RocketGate.
 *
 * This software is protected as an unpublished work under the U.S. copyright
 * laws. The above copyright notice is not intended to effect a publication of
 * this work.
 * This software is the confidential and proprietary information of RocketGate.
 * Neither the binaries nor the source code may be redistributed without prior
 * written permission from RocketGate.
 *
 * The software is provided "as-is" and without warranty of any kind, express, implied
 * or otherwise, including without limitation, any warranty of merchantability or fitness
 * for a particular purpose.  In no event shall RocketGate be liable for any direct,
 * special, incidental, indirect, consequential or other damages of any kind, or any damages
 * whatsoever arising out of or in connection with the use or performance of this software,
 * including, without limitation, damages resulting from loss of use, data or profits, and
 * whether or not advised of the possibility of damage, regardless of the theory of liability.
 * 
 */
 
 /*
 * Example $3.00 3x day trial rebills to $9.99 monthly.
 * Subsequently, Generate CrossSale for $1 4x day trial rebills $7.99/month
 * Requires Merchant Option set: PermitMultipleMemberships=true 
 */
namespace RocketGate\examples;

require '../vendor/autoload.php';

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

// Setup a couple required and testing variables
$time = time();
$cust_id = $time . '.PHPTest';
$inv_id = $time .'.TestGenerateXsell';
$merchant_id = "1";
$merchant_password = "testpassword";

//
//	Allocate the objects we need for the test.
//
$request = new GatewayRequest();
$response = new GatewayResponse();
$service = new GatewayService();

//
//	Setup the Purchase request.
//
$request->Set(GatewayRequest::MERCHANT_ID(), $merchant_id);
$request->Set(GatewayRequest::MERCHANT_PASSWORD(), $merchant_password);

// Setting the order id and customer as the unix timestamp as a convienent sequencing value
// Prepended a test name to the order id to facilitate some clarity when reviewing the tests 

$request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $cust_id);
$request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $inv_id);

// $1.00 Test
$request->Set(GatewayRequest::CURRENCY(), "USD");
$request->Set(GatewayRequest::AMOUNT(), "3.00");    		   // bill 3.00 now
$request->Set(GatewayRequest::REBILL_START(), "3"); 		  // Rebill in 3x days
$request->Set(GatewayRequest::REBILL_AMOUNT(), "9.99");		  // Rebill at 9.99
$request->Set(GatewayRequest::REBILL_FREQUENCY(), "MONTHLY"); // ongoing renewals monthly

$request->Set(GatewayRequest::CARDNO(), "4111111111111111");
$request->Set(GatewayRequest::EXPIRE_MONTH(), "02");
$request->Set(GatewayRequest::EXPIRE_YEAR(), "2010");
$request->Set(GatewayRequest::CVV2(), "999");

$request->Set(GatewayRequest::CUSTOMER_FIRSTNAME(), "Joe");
$request->Set(GatewayRequest::CUSTOMER_LASTNAME(), "PHPTester");
$request->Set(GatewayRequest::EMAIL(), "phptest@fakedomain.com");
$request->Set(GatewayRequest::USERNAME(), "phptest_user");
$request->Set(GatewayRequest::CUSTOMER_PASSWORD(), "phptest_pass");


//
//	Setup test parameters in the service and
//	request.
//
$service->SetTestMode(TRUE);

//
//	Perform the Purchase transaction.
//
if ($service->PerformPurchase($request, $response)) {
  print "Test Purchase succeeded\n";
  print "CUST: " . $cust_id . "\n";
  print "GUID: " . $response->Get(GatewayResponse::TRANSACT_ID()) . "\n";
  print "Account: " . $response->Get(GatewayResponse::MERCHANT_ACCOUNT()) . "\n";

	// Update Sticky MID
	//
	//  This would normally be two separate processes, 
	//  but for example's sake is in one process (thus we clear and set a new GatewayRequest object)
	//  The key values required are MERCHANT_CUSTOMER_ID  and MERCHANT_INVOICE_ID
	//
	//
	  $request = new GatewayRequest(); 
	  $request->Set(GatewayRequest::MERCHANT_ID(), $merchant_id);
	  $request->Set(GatewayRequest::MERCHANT_PASSWORD(), $merchant_password);  

	  $request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $cust_id);

	  // Different invoice id for xsell.
	  $inv_id = $time + 1 .'.TestGenerateXsell';
      $request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $inv_id);

	  // $1.00 Test
	  $request->Set(GatewayRequest::CURRENCY(), "USD");
	  $request->Set(GatewayRequest::AMOUNT(), "1.00");    			// bill $1.00
	  $request->Set(GatewayRequest::REBILL_START(), "4"); 		    // Rebill in 4x days
	  $request->Set(GatewayRequest::REBILL_AMOUNT(), "7.99");	    // Rebill at 7.99
	  $request->Set(GatewayRequest::REBILL_FREQUENCY(), "MONTHLY"); // ongoing renewals monthly

	  if ($service->GenerateXsell($request, $response)) {

        print "GenerateXsell Succeded\n";

	  } else {
        print "GenerateXsell Failed\n";
        print "Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
	  } 

} else {
  print "Test Purchase Failed!\n";
  print "Response Code: " .  $response->Get(GatewayResponse::RESPONSE_CODE()) . "\n";
  print "Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
  print "Exception: " .  $response->Get(GatewayResponse::EXCEPTION()) . "\n";
}

