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

#
# Example Scenario:
# $1.99 3-day trial which renews to $9.99/month subscription.
# After 1 day the user wants to upgrade immediatly to the full $9.99 subscription
#
# The example code below will upgrade the membership immediatly,
# stop the trial period, bill the user $9.99,
# and set the monthly rebill cycle starting today.
#

require_relative 'BaseTestCase'
module RocketGate


class InstantUpgradeTest < BaseTestCase
    def get_test_name
        "InstantUpgradeTest"
    end

    def test_success
# 9.99/month subscription
        @request.Set(GatewayRequest::CURRENCY, "USD")
        @request.Set(GatewayRequest::AMOUNT, "1.99");    # bill 1.99 now
        @request.Set(GatewayRequest::REBILL_START, "3"); # renew in 3 days
        @request.Set(GatewayRequest::REBILL_FREQUENCY, "MONTHLY"); # ongoing renewals monthly
        @request.Set(GatewayRequest::REBILL_AMOUNT, "9.99")

         @request.Set(GatewayRequest::IPADDRESS, '72.229.28.185')

        @request.Set(GatewayRequest::BILLING_ADDRESS, "123 Main St")
        @request.Set(GatewayRequest::BILLING_CITY, "Las Vegas")
        @request.Set(GatewayRequest::BILLING_STATE, "NV")
        @request.Set(GatewayRequest::BILLING_ZIPCODE, "89141")
        @request.Set(GatewayRequest::BILLING_COUNTRY, "US")

# Risk/Scrub Request Setting
        @request.Set(GatewayRequest::SCRUB, "IGNORE")
        @request.Set(GatewayRequest::CVV2_CHECK, "IGNORE")
        @request.Set(GatewayRequest::AVS_CHECK, "IGNORE")

#
#	Perform the Purchase transaction.
#
        assert_equal(true, 
            @service.PerformPurchase(@request, @response),
            "Perform Purchase"
        )

# UPGRADE MEMBERSHIP
#
#  This would normally be two separate processes,
#  but for example's sake is in one process (thus we clear and set a new GatewayRequest object)
#  The key values required are MERCHANT_CUSTOMER_ID and MERCHANT_INVOICE_ID.
#
        request = GatewayRequest.new
        request.Set(GatewayRequest::MERCHANT_ID, @merchantId)
        request.Set(GatewayRequest::MERCHANT_PASSWORD, @merchantPassword)
         request.Set(GatewayRequest::IPADDRESS, '72.229.28.185')

        request.Set(GatewayRequest::MERCHANT_CUSTOMER_ID, @customerId)
        request.Set(GatewayRequest::MERCHANT_INVOICE_ID, @invoiceId)

        request.Set(GatewayRequest::AMOUNT, "9.99");        # bill 9.99 now
        request.Set(GatewayRequest::REBILL_START,
            "AUTO");  # automatically set next rebill date = today + frequency.

        assert_equal(true, 
            @service.PerformRebillUpdate(request, @response),
            "Perform Rebill Update"
        )
    end
end
end
