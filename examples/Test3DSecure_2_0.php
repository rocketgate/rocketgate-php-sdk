<?php
/*
 * Copyright notice:
 * (c) Copyright 2020 RocketGate
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
namespace RocketGate\examples;

require '../vendor/autoload.php';

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

/*
 * Please ensure you have set up your merch_opts:
 * 3DSAPIKey and 3DSAPIIdentifier
 * and
 * merch_account.macct_3ds_org_unit_id
 *
 * or this test will not work correctly
 */

//
//	Allocate the objects we need for the test.
//
$request = new GatewayRequest();
$response = new GatewayResponse();
$service = new GatewayService();

//
//	Setup the Auth-Only request.
//

$request->Set(GatewayRequest::MERCHANT_ID(), "1");
$request->Set(GatewayRequest::MERCHANT_PASSWORD(), "testpassword");

// For example/testing, we set the order id and customer as the unix timestamp as a convienent sequencing value
// appending a test name to the order id to facilitate some clarity when reviewing the tests
$time = time();
$cust_id = $time . '.PHPTest';
$inv_id =  $time . '.3DSTest';

$request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $cust_id);
$request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $inv_id);

$request->Set(GatewayRequest::CURRENCY(), "USD");
$request->Set(GatewayRequest::AMOUNT(), "9.99");    // bill 9.99 now

$request->Set(GatewayRequest::CARDNO(), "4000000000001091"); // This card will trigger a 3DS 2.0 stepUp in the TestProcessor
$request->Set(GatewayRequest::EXPIRE_MONTH(), "02");
$request->Set(GatewayRequest::EXPIRE_YEAR(), "2010");
$request->Set(GatewayRequest::CVV2(), "999");

$request->Set(GatewayRequest::CUSTOMER_FIRSTNAME(), "Joe");
$request->Set(GatewayRequest::CUSTOMER_LASTNAME(), "PHPTester");
$request->Set(GatewayRequest::EMAIL(), "phptest@fakedomain.com");

$request->Set(GatewayRequest::BILLING_ADDRESS(), "123 Main St");
$request->Set(GatewayRequest::BILLING_CITY(), "Las Vegas");
$request->Set(GatewayRequest::BILLING_STATE(), "NV");
$request->Set(GatewayRequest::BILLING_ZIPCODE(), "89141");
$request->Set(GatewayRequest::BILLING_COUNTRY(), "US");

// Risk/Scrub Request Setting
$request->Set(GatewayRequest::SCRUB(), "IGNORE");
$request->Set(GatewayRequest::CVV2_CHECK(), "IGNORE");
$request->Set(GatewayRequest::AVS_CHECK(), "IGNORE");

// Request 3DS
$request->Set(GatewayRequest::USE_3D_SECURE(), "TRUE");
$request->Set(GatewayRequest::BROWSER_USER_AGENT(), "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36");
$request->Set(GatewayRequest::BROWSER_ACCEPT_HEADER(), "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8");

//
//	Setup test parameters in the service and request.
//
$service->SetTestMode(TRUE);

//	Step 1: Perform the BIN intelligence transaction.
//
$service->PerformPurchase($request, $response);

$response_code = $response->Get(GatewayResponse::RESPONSE_CODE());
$reason_code = $response->Get(GatewayResponse::REASON_CODE());

if ($response_code != 2 &&  // RESPONSE_RISK_FAIL
    $reason_code != 225) { // REASON_3DSECURE_INITIATION
  print "Response Code: " .  $response_code . "\n";
  print "Reason Code: " . $reason_code . "\n";
  exit ("error: expected response 2 and reason 225");
}

print "3DS 2.0 Device Fingerprinting Succeeded!\n";
print "  Response Code: " .  $response_code . "\n";
print "  Reason Code: " . $reason_code . "\n";
print "  Device Fingerprinting URL: " . $response->Get(GatewayResponse::_3DSECURE_DEVICE_COLLECTION_URL()) . "\n";
print "  Device Fingerprinting JWT: " . $response->Get(GatewayResponse::_3DSECURE_DEVICE_COLLECTION_JWT()) . "\n";
print "  Exception: " .  $response->Get(GatewayResponse::EXCEPTION()) . "\n";

// Recycle the first request and add two new fields
$request->Set(GatewayRequest::_3DSECURE_DF_REFERENCE_ID(), "fake");
$request->Set(GatewayRequest::_3DSECURE_REDIRECT_URL(), "fake");

//	Step 2: Perform the Lookup transaction.
//
if ($service->PerformPurchase($request, $response)) {
  print "Purchase succeeded\n";
  print "Response Code: " .  $response->Get(GatewayResponse::RESPONSE_CODE()) . "\n";
  print "Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
  print "GUID: " . $response->Get(GatewayResponse::TRANSACT_ID()) . "\n";
  print "Account: " .  $response->Get(GatewayResponse::MERCHANT_ACCOUNT()) . "\n";
  print "Exception: " .  $response->Get(GatewayResponse::EXCEPTION()) . "\n";

} elseif ($response->Get(GatewayResponse::REASON_CODE()) == "202") {
  print "3DS Lookup succeeded\n";
  print "  GUID: " . $response->Get(GatewayResponse::TRANSACT_ID()) . "\n";
  print "  3DS Version: " . $response->Get(GatewayResponse::_3DSECURE_VERSION()) . "\n";
  print "  Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
  print "  PAREQ: " .  $response->Get(GatewayResponse::PAREQ()) . "\n";
  print "  ACS URL: " .  $response->Get(GatewayResponse::ACS_URL()) . "\n";
  print "  STEP-UP URL: " .  $response->Get(GatewayResponse::_3DSECURE_STEP_UP_URL()) . "\n";
  print "  STEP-UP JWT: " .  $response->Get(GatewayResponse::_3DSECURE_STEP_UP_JWT()) . "\n\n";

  //
  //	Setup the 3rd request.
  //
  $request = new GatewayRequest();

  $request->Set(GatewayRequest::MERCHANT_ID(), "1");
  $request->Set(GatewayRequest::MERCHANT_PASSWORD(), "testpassword");

  $request->Set(GatewayRequest::CVV2(), "999");

  $request->Set(GatewayRequest::REFERENCE_GUID(), $response->Get(GatewayResponse::TRANSACT_ID()));

  // In a real transaction this would include the PARES returned from the Authentication
  // On dev we send through the SimulatedPARES + TRANSACT_ID
  $pares = "SimulatedPARES" . $response->Get(GatewayResponse::TRANSACT_ID());
  $request->Set(GatewayRequest::PARES(), $pares );

  // Risk/Scrub Request Setting
  $request->Set(GatewayRequest::SCRUB(), "IGNORE");
  $request->Set(GatewayRequest::CVV2_CHECK(), "IGNORE");
  $request->Set(GatewayRequest::AVS_CHECK(), "IGNORE");

  //
  // Step 3: Perform the Purchase transaction.
  //
  if ($service->PerformPurchase($request, $response)) {
    print "Purchase succeeded\n";
    print "  Response Code: " .  $response->Get(GatewayResponse::RESPONSE_CODE()) . "\n";
    print "  Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
    print "  GUID: " . $response->Get(GatewayResponse::TRANSACT_ID()) . "\n";
  } else {
    print "Purchase failed\n";
    print "  GUID: " . $response->Get(GatewayResponse::TRANSACT_ID()) . "\n";
    print "  Response Code: " .  $response->Get(GatewayResponse::RESPONSE_CODE()) . "\n";
    print "  Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
    print "  Exception: " .  $response->Get(GatewayResponse::EXCEPTION()) . "\n";
  }

} else {
  print "Purchase failed\n";
  print "  GUID: " . $response->Get(GatewayResponse::TRANSACT_ID()) . "\n";
  print "  Response Code: " .  $response->Get(GatewayResponse::RESPONSE_CODE()) . "\n";
  print "  Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
  print "  Exception: " .  $response->Get(GatewayResponse::EXCEPTION()) . "\n";
}

?>
