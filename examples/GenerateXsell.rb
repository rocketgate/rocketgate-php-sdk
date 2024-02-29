#
# Copyright notice:
# (c) Copyright 2020 RocketGate
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

require_relative "../GatewayService.rb"
require "date";


request = RocketGate::GatewayRequest.new
response = RocketGate::GatewayResponse.new
service = RocketGate::GatewayService.new

#
#	Setup the Purchase request.
#
request.Set(RocketGate::GatewayRequest::MERCHANT_ID, 1);
request.Set(RocketGate::GatewayRequest::MERCHANT_PASSWORD, "testpassword");

# For example/testing, we set the order id and customer as the unix timestamp as a convienent sequencing value
# appending a test name to the order id to facilitate some clarity when reviewing the tests
time = DateTime.now.to_time.to_i.to_s;
invoice_id = time + ".TestGenerateXsell";
cust_id = time + ".RubyTest";

request.Set(RocketGate::GatewayRequest::MERCHANT_CUSTOMER_ID, cust_id);
request.Set(RocketGate::GatewayRequest::MERCHANT_INVOICE_ID, invoice_id);

request.Set(RocketGate::GatewayRequest::CURRENCY, "USD");
request.Set(RocketGate::GatewayRequest::AMOUNT, 1.00);

request.Set(RocketGate::GatewayRequest::CARDNO, "4111-1111-1111-1111");
request.Set(RocketGate::GatewayRequest::EXPIRE_MONTH, "02");
request.Set(RocketGate::GatewayRequest::EXPIRE_YEAR, "2010");
request.Set(RocketGate::GatewayRequest::CVV2, "999");

request.Set(RocketGate::GatewayRequest::CUSTOMER_FIRSTNAME, "Joe");
request.Set(RocketGate::GatewayRequest::CUSTOMER_LASTNAME, "RubyTester");
request.Set(RocketGate::GatewayRequest::EMAIL, "rubytest@fakedomain.com");
request.Set(RocketGate::GatewayRequest::IPADDRESS, "68.224.133.117");

request.Set(RocketGate::GatewayRequest::BILLING_ADDRESS, "123 Main St.");
request.Set(RocketGate::GatewayRequest::BILLING_CITY, "Las Vegas");
request.Set(RocketGate::GatewayRequest::BILLING_STATE, "NV");
request.Set(RocketGate::GatewayRequest::BILLING_ZIPCODE, "89141");
request.Set(RocketGate::GatewayRequest::BILLING_COUNTRY, "US");

# Risk/Scrub Request Setting
request.Set(RocketGate::GatewayRequest::AVS_CHECK, "IGNORE");
request.Set(RocketGate::GatewayRequest::CVV2_CHECK, "IGNORE");
request.Set(RocketGate::GatewayRequest::SCRUB, "IGNORE");

#
#      Setup test parameters in the service.
#
service.SetTestMode(true);

#
#      Perform the Purchase transaction.
#
status = service.PerformPurchase(request, response)
if (status)
  puts "Purchase succeeded";
  puts "GUID: " << response.Get(RocketGate::GatewayResponse::TRANSACT_ID)
  puts "Response Code: " << response.Get(RocketGate::GatewayResponse::RESPONSE_CODE)
  puts "Reason Code: " << response.Get(RocketGate::GatewayResponse::REASON_CODE)
  puts "Account: " << response.Get(RocketGate::GatewayResponse::MERCHANT_ACCOUNT)

else 
  puts "Purchase failed\n"
  puts "GUID: " << response.Get(RocketGate::GatewayResponse::TRANSACT_ID)
  puts "Response Code: " << response.Get(RocketGate::GatewayResponse::RESPONSE_CODE)
  puts "Reason Code: " << response.Get(RocketGate::GatewayResponse::REASON_CODE)
  puts "Exception: " << response.Get(RocketGate::GatewayResponse::EXCEPTION)
  exit
end

#
#	Setup the GenerateXsell transaction
#
request = RocketGate::GatewayRequest.new
request.Set(RocketGate::GatewayRequest::MERCHANT_ID, 1);
request.Set(RocketGate::GatewayRequest::MERCHANT_PASSWORD, "testpassword");
request.Set(RocketGate::GatewayRequest::MERCHANT_CUSTOMER_ID, cust_id);

# Different invoice id for xsell.
invoice_id = time + ".xs" + ".TestGenerateXsell";
request.Set(RocketGate::GatewayRequest::MERCHANT_INVOICE_ID, invoice_id);

# $1 4 day trial, rebills 9.99 monthly
request.Set(RocketGate::GatewayRequest::AMOUNT, "1.00");
request.Set(RocketGate::GatewayRequest::REBILL_START, "4");
request.Set(RocketGate::GatewayRequest::REBILL_AMOUNT, "9.99");
request.Set(RocketGate::GatewayRequest::REBILL_FREQUENCY, "MONTHLY");

#
#	Perform the GenerateXsell transaction.
#
status = service.GenerateXsell(request, response)
if (status)
  puts "GenerateXsell succeeded";
else 
  puts "GenerateXsell failed\n"
  puts "Reason Code: " << response.Get(RocketGate::GatewayResponse::REASON_CODE)
end

