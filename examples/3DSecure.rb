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
# for a particular purpose.  In no event shall RocketGate liable for any direct,
# special, incidental, indirect, consequential or other damages of any kind, or any damages
# whatsoever arising out of or in connection with the use or performance of this software,
# including, without limitation, damages resulting from loss of use, data or profits, and
# whether or not advised of the possibility of damage, regardless of the theory of liability.
#
#
# Example $9.99 USD 3DSecure purchase.

require_relative "../GatewayService.rb"
# Date class is not required but used in this example.
require "date";

# Setup a couple required and testing variables
time = DateTime.now.to_time.to_i.to_s;
cust_id = time + '.RubyTest';
inv_id = time +'.3DSTest';
merchant_id = "1";
merchant_password = "testpassword";

request = RocketGate::GatewayRequest.new
response = RocketGate::GatewayResponse.new
service = RocketGate::GatewayService.new

#
#	Setup the Auth-Only request.
#
request.Set(RocketGate::GatewayRequest::MERCHANT_ID, merchant_id);
request.Set(RocketGate::GatewayRequest::MERCHANT_PASSWORD, merchant_password);

# For example/testing, we set the order id and customer as the unix timestamp as a convienent sequencing value
# appending a test name to the order id to facilitate some clarity when reviewing the tests
request.Set(RocketGate::GatewayRequest::MERCHANT_CUSTOMER_ID, cust_id);
request.Set(RocketGate::GatewayRequest::MERCHANT_INVOICE_ID, inv_id);

# $9.99
request.Set(RocketGate::GatewayRequest::CURRENCY, "USD");
request.Set(RocketGate::GatewayRequest::AMOUNT, 9.99);

request.Set(RocketGate::GatewayRequest::CARDNO, "4111-1111-1111-1111");
request.Set(RocketGate::GatewayRequest::EXPIRE_MONTH, "02");
request.Set(RocketGate::GatewayRequest::EXPIRE_YEAR, "2030");
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

# Request 3DS
request.Set(RocketGate::GatewayRequest::USE_3D_SECURE, "TRUE");
request.Set(RocketGate::GatewayRequest::BROWSER_USER_AGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36");
request.Set(RocketGate::GatewayRequest::BROWSER_ACCEPT_HEADER, "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8");


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
  puts "  GUID: " + response.Get(RocketGate::GatewayResponse::TRANSACT_ID)

elsif (response.Get(RocketGate::GatewayResponse::REASON_CODE) == "202")
  puts "3DS Lookup succeeded";
  puts "  GUID: " + response.Get(RocketGate::GatewayResponse::TRANSACT_ID)

#
#	Setup the 2nd request
#
  request = RocketGate::GatewayRequest.new
  request.Set(RocketGate::GatewayRequest::MERCHANT_ID, merchant_id);
  request.Set(RocketGate::GatewayRequest::MERCHANT_PASSWORD, merchant_password);

  request.Set(RocketGate::GatewayRequest::CVV2, "999");
  request.Set(RocketGate::GatewayRequest::AVS_CHECK, "IGNORE");
  request.Set(RocketGate::GatewayRequest::CVV2_CHECK, "IGNORE");
  request.Set(RocketGate::GatewayRequest::SCRUB, "IGNORE");

  request.Set(RocketGate::GatewayRequest::REFERENCE_GUID, response.Get(RocketGate::GatewayResponse::TRANSACT_ID));

  # In a real transaction this would include the PARES returned from the Authentication
  # On dev we send through the SimulatedPARES + TRANSACT_ID
  pares = "SimulatedPARES" + response.Get(RocketGate::GatewayResponse::TRANSACT_ID);
  request.Set(RocketGate::GatewayRequest::PARES, pares);

  #
  # Perform the Purchase transaction
  #
  status = service.PerformPurchase(request, response)

  if (status)
    puts "3DS Purchase Successful\n";
    puts "  GUID: " + response.Get(RocketGate::GatewayResponse::TRANSACT_ID)

  else 
    puts "3DS Purchase Failed\n"
    puts "  GUID: " + response.Get(RocketGate::GatewayResponse::TRANSACT_ID)
    puts "  Reason Code: " + response.Get(RocketGate::GatewayResponse::REASON_CODE)
  end

else 
  puts "3DS Lookup failed\n"
  puts "  GUID: " + response.Get(RocketGate::GatewayResponse::TRANSACT_ID)
  puts "  Reason Code: " + response.Get(RocketGate::GatewayResponse::REASON_CODE)
  exit
end


