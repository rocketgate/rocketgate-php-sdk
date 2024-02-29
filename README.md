![rocketgate-ruby-sdk](http://rocketgate.com/images/logo_rocketgate.png)

RocketGate Gateway Ruby SDK
===========

The Ruby Software Development Kit and Test Scripts

Documentation is available in RocketGate's helpdesk at https://help.rocketgate.com/support/solutions/28000015702

Docs related to this repository are located at:

1. GatewayService: https://help.rocketgate.com/support/solutions/articles/28000018238-gatewayservice
2. GatewayRequest: https://help.rocketgate.com/support/solutions/articles/28000018237-gatewayrequest
3. GatewayResponse: https://help.rocketgate.com/support/solutions/articles/28000018236-gatewayresponse
4. GatewayResponse Error / Decline Codes: https://help.rocketgate.com/support/solutions/articles/28000018169-gatewayresponse-error-decline-codes

## Project structure
- `/examples` - contains sample usages of the Gateway SDK for a variety of purchase scenarios to assist with your integration
- `/tests` - contains integration examples with RocketGate Gateway that can be run with ruby as an integration test suite
- `/` - contains core implementation of the Gateway SDK (`GatewayRequest.rb`, `GatewayResponse.rb`, `GatewayService.rb`)

## Running integration tests
  
```shell
ruby tests/runall.rb
```
