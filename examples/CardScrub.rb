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

request = RocketGate::GatewayRequest.new
response = RocketGate::GatewayResponse.new
service = RocketGate::GatewayService.new

#
#	Setup the Purchase request.
#
request.Set(RocketGate::GatewayRequest::MERCHANT_ID, 1);
request.Set(RocketGate::GatewayRequest::MERCHANT_PASSWORD, "testpassword");
request.Set(RocketGate::GatewayRequest::CARDNO, "4111-1111-1111-1111");

request.Set(RocketGate::GatewayRequest::MERCHANT_CUSTOMER_ID, "Customer-1");

request.Set(RocketGate::GatewayRequest::BILLING_ADDRESS, "317 Clydesdale Drive");
request.Set(RocketGate::GatewayRequest::BILLING_CITY, "Stephens City");
request.Set(RocketGate::GatewayRequest::BILLING_STATE, "Virginia");
request.Set(RocketGate::GatewayRequest::BILLING_ZIPCODE, "22655");
request.Set(RocketGate::GatewayRequest::BILLING_COUNTRY, "US");

request.Set(RocketGate::GatewayRequest::EMAIL, "example@fakedomain.com");

#
#      Setup test parameters in the service.
#
service.SetTestMode(true);

#
#      Perform the scrub transaction.
#
status = service.PerformCardScrub(request, response)
if (status)
  puts "CardScrub succeeded";
  puts "Response Code: " << response.Get(RocketGate::GatewayResponse::RESPONSE_CODE)
  puts "Reason Code: " << response.Get(RocketGate::GatewayResponse::REASON_CODE)
  puts "Scrub: " << response.Get(RocketGate::GatewayResponse::SCRUB_RESULTS)

else 
  puts "CardScrub failed\n"
  puts "Response Code: " << response.Get(RocketGate::GatewayResponse::RESPONSE_CODE)
  puts "Reason Code: " << response.Get(RocketGate::GatewayResponse::REASON_CODE)
  puts "Scrub: " << response.Get(RocketGate::GatewayResponse::SCRUB_RESULTS)
  puts "Exception: " << response.Get(RocketGate::GatewayResponse::EXCEPTION)
end

