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

class UploadTest extends BaseTestCase
{
    function getTestName(): string
    {
        return "UploadTest";
    }

    function test()
    {

// Setting the order id and customer as the unix timestamp as a convenient sequencing value
// Prepended a test name to the order id to facilitate some clarity when reviewing the tests

        $this->request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), "Customer-1");

        $this->request->Set(GatewayRequest::CARDNO(), "4111111111111111");
        $this->request->Set(GatewayRequest::EXPIRE_MONTH(), "12");
        $this->request->Set(GatewayRequest::EXPIRE_YEAR(), "2012");

        $this->request->Set(GatewayRequest::CUSTOMER_PASSWORD(), "ThePassword");

        $this->request->Set(GatewayRequest::BILLING_ADDRESS(), "123 Main St");
        $this->request->Set(GatewayRequest::BILLING_CITY(), "Las Vegas");
        $this->request->Set(GatewayRequest::BILLING_STATE(), "NV");
        $this->request->Set(GatewayRequest::BILLING_ZIPCODE(), "89141");
        $this->request->Set(GatewayRequest::BILLING_COUNTRY(), "US");

//
//	Setup test parameters in the service
//
        $this->service->SetTestMode(true);

//
//	Perform the Purchase transaction.
//
        $this->assertTrue(
            $this->service->PerformCardUpload($this->request, $this->response),
            "Perform Card Upload"
        );
    }
}
