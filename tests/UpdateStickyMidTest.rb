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


class UpdateStickyMidTest < BaseTestCase
    def get_test_name
        "UpdateStickyMidTest"
    end

    def test_success
# 1.00 Test
        @request.Set(GatewayRequest::CURRENCY, "USD")
        @request.Set(GatewayRequest::AMOUNT, "1.00");    # bill 1.00 now
        @request.Set(GatewayRequest::REBILL_FREQUENCY, "MONTHLY"); # ongoing renewals monthly

        @request.Set(GatewayRequest::USERNAME, "phptest_user")
        @request.Set(GatewayRequest::CUSTOMER_PASSWORD, "phptest_pass")

#
#	Perform the Purchase transaction.
#
        assert_equal(true, 
            @service.PerformPurchase(@request, @response),
            "Perform Purchase"
        )

# Update Sticky MID
#
#  This would normally be two separate processes,
#  but for example's sake is in one process (thus we clear and set a new GatewayRequest object)
#  The key values required are MERCHANT_CUSTOMER_ID  and MERCHANT_INVOICE_ID
#
#
        request = GatewayRequest.new
        request.Set(GatewayRequest::MERCHANT_ID, @merchantId)
        request.Set(GatewayRequest::MERCHANT_PASSWORD, @merchantPassword)

        request.Set(GatewayRequest::MERCHANT_CUSTOMER_ID, @customerId)
        request.Set(GatewayRequest::MERCHANT_INVOICE_ID, @invoiceId)

# Pass the Merchant Account Sequence # you can find in Mission Control. Using "2" as an example
        request.Set(GatewayRequest::MERCHANT_ACCOUNT, "2")

        assert_equal(true, 
            @service.PerformRebillUpdate(request, @response),
            "Update Sticky MID"
        )
    end
end
end
