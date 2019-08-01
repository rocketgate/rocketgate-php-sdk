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
 * Example $9.99 USD monthly subscription purchase.
 * Subsequently, Check the status of the subscription
 */
 
require '../vendor/autoload.php';

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

// Setup a couple required and testing variables
$time = time();
$cust_id = $time . '.PHPTest';
$inv_id = $time .'.RebillStatusTest';
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

// $9.99/month subscription
$request->Set(GatewayRequest::CURRENCY(), "USD");
$request->Set(GatewayRequest::AMOUNT(), "9.99");    // bill 9.99 now
$request->Set(GatewayRequest::REBILL_FREQUENCY(), "MONTHLY"); // ongoing renewals monthly

$request->Set(GatewayRequest::CARDNO(), "4111111111111111");
$request->Set(GatewayRequest::EXPIRE_MONTH(), "02");
$request->Set(GatewayRequest::EXPIRE_YEAR(), "2010");
$request->Set(GatewayRequest::CVV2(), "999");

$request->Set(GatewayRequest::CUSTOMER_FIRSTNAME(), "Joe");
$request->Set(GatewayRequest::CUSTOMER_LASTNAME(), "PHPTester");
$request->Set(GatewayRequest::EMAIL(), "phptest@fakedomain.com");
// $request->Set(GatewayRequest::IPADDRESS(), $_SERVER['REMOTE_ADDR']);

$request->Set(GatewayRequest::BILLING_ADDRESS(), "123 Main St");
$request->Set(GatewayRequest::BILLING_CITY(), "Las Vegas");
$request->Set(GatewayRequest::BILLING_STATE(), "NV");
$request->Set(GatewayRequest::BILLING_ZIPCODE(), "89141");
$request->Set(GatewayRequest::BILLING_COUNTRY(), "US");


// Risk/Scrub Request Setting
$request->Set(GatewayRequest::SCRUB(), "IGNORE");
$request->Set(GatewayRequest::CVV2_CHECK(), "IGNORE");
$request->Set(GatewayRequest::AVS_CHECK(), "IGNORE");

//
//	Setup test parameters in the service and
//	request.
//
$service->SetTestMode(TRUE);

//
//	Perform the Purchase transaction.
//
if ($service->PerformPurchase($request, $response)) {
  print "1. Purchase succeeded\n";

	// CHECK Rebill Status
	//
	//  This would normally be two separate processes, 
	//  but for example's sake is in one process (thus we clear and set a new GatewayRequest object)
	//  The key values required are MERCHANT_CUSTOMER_ID and MERCHANT_INVOICE_ID.
	//
	//
	  $request = new GatewayRequest(); 
	  $request->Set(GatewayRequest::MERCHANT_ID(), $merchant_id);
	  $request->Set(GatewayRequest::MERCHANT_PASSWORD(), $merchant_password);  

	  $request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $cust_id);
	  $request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $inv_id);

	  if ($service->PerformRebillUpdate($request, $response)) {

        if ( is_null( $response->Get(GatewayResponse::REBILL_END_DATE()) ) ) {
            print "2. User is Active and Set to Rebill\n";
  		    print " Rebill Date: " . $response->Get(GatewayResponse::REBILL_DATE()) . "\n";

        } else {
            print "2. User is Active and Set to Cancel\n";
  		    print "  Cancel Date: " . $response->Get(GatewayResponse::REBILL_END_DATE()) . "\n";
        }

  		print " Join Date: " . $response->Get(GatewayResponse::JOIN_DATE()) . "\n";
  		print " Join Amount: " . $response->Get(GatewayResponse::JOIN_AMOUNT()) . "\n";

  		print " Rebill Amount: " . $response->Get(GatewayResponse::REBILL_AMOUNT()) . "\n";
  		print " Rebill Frequency: " . $response->Get(GatewayResponse::REBILL_FREQUENCY()) . "\n";
  		print " Rebill Status: " . $response->Get(GatewayResponse::REBILL_STATUS()) . "\n";

  		print " Last Billing Date: " . $response->Get(GatewayResponse::LAST_BILLING_DATE()) . "\n";
  		print " Last Billing Amount: " . $response->Get(GatewayResponse::LAST_BILLING_AMOUNT()) . "\n";
  		print " Last Reason Code: " . $response->Get(GatewayResponse::LAST_REASON_CODE()) . "\n";

	  } else {
        print "2.  User is Canceled\n";
	  } 

} else {
  print "1. Purchase failed\n";
  print "Response Code: " .  $response->Get(GatewayResponse::RESPONSE_CODE()) . "\n";
  print "Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
  print "Exception: " .  $response->Get(GatewayResponse::EXCEPTION()) . "\n";
}

