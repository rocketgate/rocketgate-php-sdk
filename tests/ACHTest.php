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

class ACHTest extends BaseTestCase
{
    function getTestName() : string
    {
        return "ACHTest";
    }

    function test()
    {
//
//	Provide information about the customer.
//
        $this->request->Set(GatewayRequest::CUSTOMER_FIRSTNAME(), "Joe");
        $this->request->Set(GatewayRequest::CUSTOMER_LASTNAME(), "PHPTester");
        $this->request->Set(GatewayRequest::BILLING_ADDRESS(), "123 Main St");
        $this->request->Set(GatewayRequest::BILLING_CITY(), "Las Vegas");
        $this->request->Set(GatewayRequest::BILLING_STATE(), "NV");
        $this->request->Set(GatewayRequest::BILLING_ZIPCODE(), "89141");
        $this->request->Set(GatewayRequest::BILLING_COUNTRY(), "US");
        $this->request->Set(GatewayRequest::IPADDRESS(), "10.10.10.10");

//
//	Provide information about the purchase.
//
        $this->request->Set(GatewayRequest::AMOUNT(), "9.99");

//
//	Provide information about the bank account.
//
//	Notes:  Accounts default to 'checking account'.  If the
//		account is a savings account, set the SAVINGS_ACCOUNT
//		parameter to TRUE.
//
//		SBW requires the last four digits of the customer's
//		Social Security Number.  This is sent in the SS_NUMBER
//		parameter.
//
        $this->request->Set(GatewayRequest::ROUTING_NO(), "999999999");
        $this->request->Set(GatewayRequest::ACCOUNT_NO(), "112233");
        $this->request->Set(GatewayRequest::SAVINGS_ACCOUNT(), "TRUE");
        $this->request->Set(GatewayRequest::SS_NUMBER(), "1111");

// Risk/Scrub Request Setting
        $this->request->Set(GatewayRequest::SCRUB(), "IGNORE");

//
//	Perform the Purchase transaction.
//
        $this->assertTrue(
            $this->service->PerformPurchase($this->request, $this->response),
            "Perform Purchase"
        );
    }
}
