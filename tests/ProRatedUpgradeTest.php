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
 * Example Scenario:
* $9.99 USD monthly subscription purchase.
* Subsequently, the user wants an instant upgrade to the $19.95 subscription.
*
* The example code below will run a pro-rated transaction now (for example 3.25)
* and update the future rebill amounts to $19.95.
*/

namespace RocketGate\Sdk\Tests;

use RocketGate\Sdk\GatewayRequest;

class ProRatedUpgradeTest extends BaseTestCase
{
    function getTestName() : string
    {
        return "ProRatedUpgradeTest";
    }

    function test()
    {
// $9.99/month subscription
        $this->request->Set(GatewayRequest::CURRENCY(), "USD");
        $this->request->Set(GatewayRequest::AMOUNT(), "9.99");    // bill 9.99 now
        $this->request->Set(GatewayRequest::REBILL_FREQUENCY(), "MONTHLY"); // ongoing renewals monthly

         $this->request->Set(GatewayRequest::IPADDRESS(), '72.229.28.185');

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
            "Perform Purchase"
        );

// UPGRADE MEMBERSHIP
//
//  This would normally be two separate processes,
//  but for example's sake is in one process (thus we clear and set a new GatewayRequest object)
//  The key values required are MERCHANT_CUSTOMER_ID and MERCHANT_INVOICE_ID.
//
//  Run 3.25 now and set rebill amount to 19.95
//
        $request = new GatewayRequest();
        $request->Set(GatewayRequest::MERCHANT_ID(), $this->merchantId);
        $request->Set(GatewayRequest::MERCHANT_PASSWORD(), $this->merchantPassword);
         $request->Set(GatewayRequest::IPADDRESS(), '72.229.28.185');

        $request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $this->customerId);
        $request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $this->invoiceId);

        $request->Set(GatewayRequest::AMOUNT(), "3.25");           // bill today amt
        $request->Set(GatewayRequest::REBILL_AMOUNT(), "19.95"); // set rebill amt

        $this->assertTrue(
            $this->service->PerformRebillUpdate($request, $this->response),
            "Perform Pro-rated Upgrade"
        );
    }
}
