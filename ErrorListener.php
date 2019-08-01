<?php
/*
 * Copyright notice:
 * (c) Copyright 2019 RocketGate
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

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\Tests\BaseTestCase;

class ErrorListener implements TestListener
{
    use TestListenerDefaultImplementation;

    public function addFailure(Test $test, AssertionFailedError $e, $time)
    {
        if ($test instanceof BaseTestCase) {
            $response = $test->getResponse();
            print <<<OUTPUT
//////////////////////////////////////////////////////////////////////
// {$test->getTestName()} HAS FAILED
// GUID: {$response->Get(GatewayResponse::TRANSACT_ID())}
// Response Code: {$response->Get(GatewayResponse::RESPONSE_CODE())}
// Reason Code: {$response->Get(GatewayResponse::REASON_CODE())}
// Exception: {$response->Get(GatewayResponse::EXCEPTION())}
// Auth No: {$response->Get(GatewayResponse::AUTH_NO())}
// AVS: {$response->Get(GatewayResponse::AVS_RESPONSE())}
// Cancel Date: {$response->Get(GatewayResponse::REBILL_END_DATE())}
// Card Hash: {$response->Get(GatewayResponse::CARD_HASH())}
// Card Issuer: {$response->Get(GatewayResponse::CARD_ISSUER_NAME())}
// CVV2: {$response->Get(GatewayResponse::CVV2_CODE())}
// Rebill Date: {$response->Get(GatewayResponse::REBILL_DATE())}
// Scrub: {$response->Get(GatewayResponse::SCRUB_RESULTS())}
//////////////////////////////////////////////////////////////////////
OUTPUT;
        }
    }
}
