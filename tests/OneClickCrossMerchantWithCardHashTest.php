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

namespace RocketGate\Sdk\Tests;

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;

class OneClickCrossMerchantWithCardHashTest extends BaseTestCase
{
    function getTestName() : string
    {
        return "CardHashTest";
    }

	function test()
	{
		$merchant_id_1c = "1256059862";
		$merchant_password_1c = "LLSgMD8tSkVkZED3";

// Example join on Site 1
		$this->request->Set(GatewayRequest::MERCHANT_SITE_ID(), 1);

// $9.99/month subscription
		$this->request->Set(GatewayRequest::CURRENCY(), "USD");
		$this->request->Set(GatewayRequest::AMOUNT(), "9.99");    // bill 9.99

		$this->request->Set(GatewayRequest::BILLING_ADDRESS(), "123 Main St");
		$this->request->Set(GatewayRequest::BILLING_CITY(), "Las Vegas");
		$this->request->Set(GatewayRequest::BILLING_STATE(), "NV");
		$this->request->Set(GatewayRequest::BILLING_ZIPCODE(), "89141");
		$this->request->Set(GatewayRequest::BILLING_COUNTRY(), "US");

// Risk/Scrub Request Setting
		$this->request->Set(GatewayRequest::SCRUB(), "IGNORE");
		$this->request->Set(GatewayRequest::CVV2_CHECK(), "IGNORE");
		$this->request->Set(GatewayRequest::AVS_CHECK(), "IGNORE");

//
//	Perform the Purchase transaction.
//
		$this->assertTrue(
			$this->service->PerformPurchase($this->request, $this->response),
			"First purchase for one-click"
		);

		$request = new GatewayRequest();
		$request->Set(GatewayRequest::MERCHANT_ID(), $merchant_id_1c);
		$request->Set(GatewayRequest::MERCHANT_PASSWORD(), $merchant_password_1c);

		$request->Set(GatewayRequest::REFERRING_MERCHANT_ID(), $this->merchantId);
		$request->Set(GatewayRequest::REFERRED_CUSTOMER_ID(), $this->customerId);
// Run additional purchase using card_hash
		$request->Set(GatewayRequest::CARD_HASH(), $this->response->Get(GatewayResponse::CARD_HASH()));

		$request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $this->customerId . '1CTEST');
		$request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $this->invoiceId . '1CTEST');

// Example 1-click on Site 2
		$request->Set(GatewayRequest::MERCHANT_SITE_ID(), 2);

		$request->Set(GatewayRequest::AMOUNT(), "14.99");
		$request->Set(GatewayRequest::REBILL_FREQUENCY(), "MONTHLY");

		$this->assertTrue(
			$this->service->PerformPurchase($request, $this->response),
			"1Click Purchase"
		);
	}
}
