#
# Copyright notice:
# (c) Copyright 2018 RocketGate
# All rights reserved.
#
# The copyright notice must not be removed without specific, prior
# written permission from RocketGate.
#
# This software is protected as an unpublished work under the U.S. copyright
# laws. The above copyright notice is not intended to effect a publication of
# this work.
# This software is the confidential and proprietary information of RocketGate.
# Neither the binaries nor the source code may be redistributed without prior
# written permission from RocketGate.
#
# The software is provided "as-is" and without warranty of any kind, express, implied
# or otherwise, including without limitation, any warranty of merchantability or fitness
# for a particular purpose.  In no event shall RocketGate be liable for any direct,
# special, incidental, indirect, consequential or other damages of any kind, or any damages
# whatsoever arising out of or in connection with the use or performance of this software,
# including, without limitation, damages resulting from loss of use, data or profits, and
# whether or not advised of the possibility of damage, regardless of the theory of liability.
# 

require_relative 'BaseTestCase'
module RocketGate


class ACHTest < BaseTestCase
    def get_test_name
        "ACHTest"
    end

    def test_success
#
#	Provide information about the customer.
#
        @request.Set(GatewayRequest::CUSTOMER_FIRSTNAME, "Joe")
        @request.Set(GatewayRequest::CUSTOMER_LASTNAME, "PHPTester")
        @request.Set(GatewayRequest::BILLING_ADDRESS, "123 Main St")
        @request.Set(GatewayRequest::BILLING_CITY, "Las Vegas")
        @request.Set(GatewayRequest::BILLING_STATE, "NV")
        @request.Set(GatewayRequest::BILLING_ZIPCODE, "89141")
        @request.Set(GatewayRequest::BILLING_COUNTRY, "US")
        @request.Set(GatewayRequest::IPADDRESS, "10.10.10.10")

#
#	Provide information about the purchase.
#
        @request.Set(GatewayRequest::AMOUNT, "9.99")

#
#	Provide information about the bank account.
#
#	Notes:  Accounts default to 'checking account'.  If the
#		account is a savings account, set the SAVINGS_ACCOUNT
#		parameter to TRUE.
#
#		SBW requires the last four digits of the customer's
#		Social Security Number.  This is sent in the SS_NUMBER
#		parameter.
#
        @request.Set(GatewayRequest::ROUTING_NO, "999999999")
        @request.Set(GatewayRequest::ACCOUNT_NO, "112233")
        @request.Set(GatewayRequest::SAVINGS_ACCOUNT, "TRUE")
        @request.Set(GatewayRequest::SS_NUMBER, "1111")

# Risk/Scrub Request Setting
        @request.Set(GatewayRequest::SCRUB, "IGNORE")

#
#	Perform the Purchase transaction.
#
        assert_equal(true, 
            @service.PerformPurchase(@request, @response),
            "Perform Purchase"
        )
    end
end
end
