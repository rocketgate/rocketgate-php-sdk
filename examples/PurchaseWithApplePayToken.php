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
namespace RocketGate\examples;

//require '../vendor/autoload.php';

require "../src/GatewayChecksum.php";
require "../src/GatewayCodes.php";
require "../src/GatewayParameterList.php";
require "../src/GatewayRequest.php";
require "../src/GatewayResponse.php";
require "../src/GatewayService.php";

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

//
//	Allocate the objects we need for the test.
//
$request = new GatewayRequest();
$response = new GatewayResponse();
$service = new GatewayService();

$applePayToken = "{" .
    "  \"paymentData\": {\n" .
    "    \"data\": \"Y1tMUe1bca4SZvqEEdbix5hk/z7V3xzaE+BAQAfE5U+R4rC43ADYHKkOlamr+H68p80d3TzqKWRxRo7jyNSxUwQcQEkV9d2T6dlGR/pSQK1KlFqdinDdf18b3AUswa2iFTwNeAGt8eVOTRU0mNM25p3/+u+qgjT5VW2+0UA06hEVcUjOAIss6tFJ6vspPBMDip3ZfiIXM5YwTbrJd86htbFiubPLMkgs8/EpuhgRFglfNeAVKHwDKtGmpdbhJPu9if3NCb00PbTxU3jaQJB9WMyvRHnhKF4BiRxSYzdEGfUfMQgmd71yeT6LcYCCnB4IJU9oHan0orny2bgkb/kJJz2qLxpJvE8HZ6qu/klQ5harD15PA1WDED53OB14Ew8LTYerZTGWKECiQIfyFPjeE0NvYXkTEY2QjygIabMP0Q==\",\n" .
    "    \"signature\": \"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\",\n" .
    "    \"header\": {\n" .
    "      \"publicKeyHash\": \"3rlzmE4/62YzbM6Y9U4LSS74LAodq6BIEH4GCTvdhB4=\",\n" .
    "      \"ephemeralPublicKey\": \"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAE0ogZR+6Thym7Ii+Yl043kkzp4bonwgHctnQ9J5up7+kwtzl3xNE/8DL/cBmCi4QYsqJgh761gfRO6aFZd1J8bw==\",\n" .
    "      \"transactionId\": \"4790e0bf5225439acb2309d481c6a1e2057d89139cdcabf51d17d09e9fbbbf10\"\n" .
    "    },\n" .
    "    \"version\": \"EC_v1\"\n" .
    "  },\n" .
    "  \"paymentMethod\": {\n" .
    "    \"displayName\": \"Visa 0121\",\n" .
    "    \"network\": \"Visa\",\n" .
    "    \"type\": \"credit\"\n" .
    "  },\n" .
    "  \"transactionIdentifier\": \"4790e0bf5225439acb2309d481c6a1e2057d89139cdcabf51d17d09e9fbbbf10\"\n" .
    "}";
//
//	Setup the Purchase request.
//
$request->Set(GatewayRequest::MERCHANT_ID(), "1");
$request->Set(GatewayRequest::MERCHANT_PASSWORD(), "testpassword");

// For example/testing, we set the order id and customer as the unix timestamp as a convienent sequencing value
// appending a test name to the order id to facilitate some clarity when reviewing the tests
$time = time();
$request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $time . '.PHPTest');
$request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $time . '.SaleTest');
$request->Set(GatewayRequest::AMOUNT(), "9.99");

$request->Set(GatewayRequest::APPLE_PAY_TOKEN(), $applePayToken);

$request->Set(GatewayRequest::CUSTOMER_FIRSTNAME(), "Joe");
$request->Set(GatewayRequest::CUSTOMER_LASTNAME(), "PHPTester");
$request->Set(GatewayRequest::EMAIL(), "phptest@fakedomain.com");
$request->Set(GatewayRequest::IPADDRESS(), $_SERVER["REMOTE_ADDR"] ?? '');

// $request->Set(GatewayRequest::AFFILIATE(), '1234');

$request->Set(GatewayRequest::BILLING_ADDRESS(), "123 Main St");
$request->Set(GatewayRequest::BILLING_CITY(), "Las Vegas");
$request->Set(GatewayRequest::BILLING_STATE(), "NV");
$request->Set(GatewayRequest::BILLING_ZIPCODE(), "89141");
$request->Set(GatewayRequest::BILLING_COUNTRY(), "US");

//
//	Setup test parameters in the service and
//	request.
//
$service->SetTestMode(TRUE);

//
//	Perform the Purchase transaction.
//
if ($service->PerformPurchase($request, $response)) {
  print "Purchase succeeded\n";
  print "Response Code: " .  $response->Get(GatewayResponse::RESPONSE_CODE()) . "\n";
  print "Reason Code: " .  $response->Get(GatewayResponse::REASON_CODE()) . "\n";
  print "Auth No: " . $response->Get(GatewayResponse::AUTH_NO()) . "\n";
  print "AVS: " . $response->Get(GatewayResponse::AVS_RESPONSE()) . "\n";
  print "CVV2: " . $response->Get(GatewayResponse::CVV2_CODE()) . "\n";
  print "GUID: " . $response->Get(GatewayResponse::TRANSACT_ID()) . "\n";
  print "Card Issuer: " . $response->Get(GatewayResponse::CARD_ISSUER_NAME()) . "\n";
  print "Account: " .  $response->Get(GatewayResponse::MERCHANT_ACCOUNT()) . "\n";
  print "Scrub: " .  $response->Get(GatewayResponse::SCRUB_RESULTS()) . "\n";

} else {
  print "Purchase failed\n";
  print "GUID: " . $response->Get(GatewayResponse::TRANSACT_ID()) . "\n";
  print "Response Code: " .
	$response->Get(GatewayResponse::RESPONSE_CODE()) . "\n";
  print "Reason Code: " .
	$response->Get(GatewayResponse::REASON_CODE()) . "\n";
  print "Exception: " .
	$response->Get(GatewayResponse::EXCEPTION()) . "\n";
  print "Scrub: " .
	$response->Get(GatewayResponse::SCRUB_RESULTS()) . "\n";
}

