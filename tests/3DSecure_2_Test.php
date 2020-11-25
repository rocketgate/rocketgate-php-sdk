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

 namespace RocketGate\Sdk\Tests;

 use RocketGate\Sdk\GatewayRequest;
 use RocketGate\Sdk\GatewayResponse;

 /*
 * Please ensure you have set up your merch_opts:
 * 3DSAPIKey and 3DSAPIIdentifier
 * and
 * merch_account.macct_3ds_org_unit_id
 *
 * or this test will not work correctly
 */

 class ThreeDSecureTwoTest extends BaseTestCase
 {
   function getTestName() : string
   {
     return "3DSecureI2Test";
   }

   function test()
   {
     $time = time();
     $cust_id = $time . '.PHPTest';
     $inv_id =  $time . '.3DSTest';


     $this->request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $cust_id);
     $this->request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $inv_id);

     $this->request->Set(GatewayRequest::CURRENCY(), "USD");
     $this->request->Set(GatewayRequest::AMOUNT(), "9.99");    // bill 9.99 now

     $this->request->Set(GatewayRequest::CARDNO(), "4000000000001091");
     $this->request->Set(GatewayRequest::EXPIRE_MONTH(), "01");
     $this->request->Set(GatewayRequest::EXPIRE_YEAR(), "2030");
     $this->request->Set(GatewayRequest::CVV2(), "999");

     $this->request->Set(GatewayRequest::CUSTOMER_FIRSTNAME(), "Joe");
     $this->request->Set(GatewayRequest::CUSTOMER_LASTNAME(), "PHPTester");
     $this->request->Set(GatewayRequest::EMAIL(), "phptest@fakedomain.com");

     $this->request->Set(GatewayRequest::BILLING_ADDRESS(), "123 Main St");
     $this->request->Set(GatewayRequest::BILLING_CITY(), "Las Vegas");
     $this->request->Set(GatewayRequest::BILLING_STATE(), "NV");
     $this->request->Set(GatewayRequest::BILLING_ZIPCODE(), "89141");
     $this->request->Set(GatewayRequest::BILLING_COUNTRY(), "US");
     //$this->request->Set(GatewayRequest::MERCHANT_ACCOUNT(), "59");

     // Risk/Scrub Request Setting
     $this->request->Set(GatewayRequest::SCRUB(), "IGNORE");
     $this->request->Set(GatewayRequest::CVV2_CHECK(), "IGNORE");
     $this->request->Set(GatewayRequest::AVS_CHECK(), "IGNORE");

     // Request 3DS
     $this->request->Set(GatewayRequest::USE_3D_SECURE(), "TRUE");
     $this->request->Set(GatewayRequest::BROWSER_USER_AGENT(), "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36");
     $this->request->Set(GatewayRequest::BROWSER_ACCEPT_HEADER(), "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8");

     //
     //	Perform the BIN intelligence transaction
     //
     $this->service->PerformPurchase($this->request, $this->response);
     $reason_code = $this->response->Get(GatewayResponse::REASON_CODE());
     $this->assertTrue(($reason_code == 225),
     "Perform BIN intelligence"
   );

   // Recycle the first request and add two new fields
   $this->request->Set(GatewayRequest::_3DSECURE_DF_REFERENCE_ID(), "fake");
   $this->request->Set(GatewayRequest::_3DSECURE_REDIRECT_URL(), "fake");

   //
   //	Step 2: Perform the Lookup transaction.
   //
   $this->service->PerformPurchase($this->request, $this->response);

   $reason_code = $this->response->Get(GatewayResponse::REASON_CODE());
   $this->assertTrue(($reason_code == 202),
   "Perform 3D Lookup"
 );

 //
 // Setup the 3rd request
 //
 $this->request = new GatewayRequest();
 $this->request->Set(GatewayRequest::MERCHANT_ID(), $this->merchantId);
 $this->request->Set(GatewayRequest::MERCHANT_PASSWORD(), $this->merchantPassword);

 $this->request->Set(GatewayRequest::CVV2(), "999");

 $this->request->Set(GatewayRequest::REFERENCE_GUID(), $this->response->Get(GatewayResponse::TRANSACT_ID()));

 // In a real transaction this would include the PARES returned from the Authentication
 // On dev we send through the SimulatedPARES + TRANSACT_ID
 $pares = "SimulatedPARES" . $this->response->Get(GatewayResponse::TRANSACT_ID());
 $this->request->Set(GatewayRequest::PARES(), $pares );

 // Risk/Scrub Request Setting
 $this->request->Set(GatewayRequest::SCRUB(), "IGNORE");
 $this->request->Set(GatewayRequest::CVV2_CHECK(), "IGNORE");
 $this->request->Set(GatewayRequest::AVS_CHECK(), "IGNORE");

 //
 // Step 3: Perform the Purchase transaction.
 //
 $this->assertTrue(
   $this->service->PerformPurchase($this->request, $this->response),
   "Perform Purchase"
  );
  }
}
