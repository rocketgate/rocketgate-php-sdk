![rocketgate-php-sdk](http://rocketgate.com/images/logo_rocketgate.png)

Rocketgate Gateway PHP SDK
===========

This library is compatible with PHP 8.0 or greater 
(refer to PHP Supported Versions [here](https://www.php.net/supported-versions.php)).

This library supports Composer and Namespaces and thus is NOT backwards compatible with 
our old (legacy) PHP sdks: https://github.com/rocketgate/rocketgate-php-legacy-sdk

## Project structure
/examples - contains sample usages of the Gateway SDK for a variety of purchase scenarios to assist with your integration

/src - contains core implementation of the Gateway SDK

/tests - contains integration examples with Rocketgate Gateway that can be run with phpunit as an integration test suite


## Installation using composer

Install with composer (available on packagist.org):

```sh
composer require --update-no-dev rocketgate/sdk
```

## Installation without composer

Create a vendor folder (or use your project's external dependencies folder):
```sh
mkdir -p vendor/rocketgate
```

Clone into that folder
```sh
git clone https://github.com/rocketgate/rocketgate-php-sdk.git vendor/rocketgate
```

Add classes to your project autoloader or manually (as shown below). 
```php
<?php

require "vendor/rocketgate/src/GatewayChecksum.php";
require "vendor/rocketgate/src/GatewayCodes.php";
require "vendor/rocketgate/src/GatewayParameterList.php";
require "vendor/rocketgate/src/GatewayRequest.php";
require "vendor/rocketgate/src/GatewayResponse.php";
require "vendor/rocketgate/src/GatewayService.php";

use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

$request  = new GatewayRequest();
$response = new GatewayResponse();
$service  = new GatewayService();

$request->Set(GatewayRequest::MERCHANT_ID(), "1");
$request->Set(GatewayRequest::MERCHANT_PASSWORD(), "testpassword");

// [...]
```

## Usage

Integration examples with Rocketgate Gateway are placed under `/tests` folder.  

## Run full test suite (without RG docker container)
From Bash shell
```sh
$ sh vendor/rocketgate/sdk/startup.sh
```

Manually from sdk folder (/vendor/rocketgate/sdk)
```sh
$ ./vendor/bin/phpunit
```

## Run individual tests
From sdk folder (/vendor/rocketgate/sdk)
```sh
$ ./vendor/bin/phpunit ./tests/AuthOnlyTest.php
```

## Run individual example scripts
From examples folder  (requires php executable on system $PATH)
```sh
$ php ./Purchase.php
```

## Run full test suite (with RG docker container)

We recommend using both [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/) and 
[Docker Compose](https://docs.docker.com/compose/install/) in order to run full test suite.

1. Start docker container.
 
```sh
docker-compose up -d
```
The command above might take longer at first execution because all PHP Docker container 
dependencies will be downloaded and installed.

2. Run `startup.sh` script.
```sh
docker exec -it $(docker-compose ps -q --filter name=cli_php) bash startup.sh
```

## Important notes
- To run tests PHP >=8.0 is required.
- Startup script `startup.sh` installs composer PHP dependencies and run complete test suite.
- Output should look like this:
  ```
  Do not run Composer as root/super user! See https://getcomposer.org/root for details
  Loading composer repositories with package information
  Installing dependencies (including require-dev) from lock file
  Nothing to install or update
  Generating autoload files
  PHPUnit 8.5.28 by Sebastian Bergmann and contributors.
  
  Runtime:       PHP 8.1.9 with Xdebug 3.1.5
  Configuration: /var/client/phpunit.xml
  
  ..........................                                        26 / 26 (100%)
  
  Time: 14.12 seconds, Memory: 6.00MB
  
  OK (26 tests, 46 assertions)
  ```
- Successful test represent a dot (".").
- Failed test prints Rocketgate request data along with "F" character. Example:
```
//////////////////////////////////////////////////////////////////////
// ACHTest HAS FAILED
// GUID: 100016C8BAE1717
// Response Code: 0
// Reason Code: 0
// Exception: 
// Auth No: 247218
// AVS: 
// Cancel Date: 
// Card Hash: m77xlHZiPKVsF9p1/VdzTb+CUwaGBDpuSRxtcb7+j24=
// Card Issuer: JPMORGAN CHASE BANK, N.A.
// CVV2: 
// Rebill Date: 
// Scrub: NEGDB=0,PROFILE=0,ACTIVITY=0
//////////////////////////////////////////////////////////////////////F
```  
- Any non-compliant Rocketgate modification made on source code SDK will make `::testComplianceModifications` 
fail, as shown below:
```
1) RocketGate\Sdk\Tests\GatewayChecksumTest::testComplianceModifications
Modified version. Current checksum 0646c7f28688c3f2ad0c37499e7113d6 does not match base 4b086e326a9d6cb310079994896792c1.
Failed asserting that 'P7.1m' does not contain "m".

/var/client/tests/GatewayChecksumTest.php:17
``` 
