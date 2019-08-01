<?php

namespace RocketGate\Sdk\Tests;

use PHPUnit\Framework\TestCase;
use RocketGate\Sdk\GatewayRequest;
use RocketGate\Sdk\GatewayResponse;
use RocketGate\Sdk\GatewayService;

abstract class BaseTestCase extends TestCase
{
    /**
     * @var GatewayService
     */
    protected $service;

    /**
     * @var GatewayRequest
     */
    protected $request;

    /**
     * @var GatewayResponse
     */
    protected $response;

    /**
     * @var int
     */
    protected $merchantId = 1;

    /**
     * @var string
     */
    protected $merchantPassword = 'testpassword';

    /**
     * @var string
     */
    protected $customerId;

    /**
     * @var string
     */
    protected $invoiceId;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->service  = new GatewayService(true);
        $this->response = new GatewayResponse();
        $this->request  = new GatewayRequest();

        // Merchant data
        $this->request->Set(GatewayRequest::MERCHANT_ID(), $this->merchantId);
        $this->request->Set(GatewayRequest::MERCHANT_PASSWORD(), $this->merchantPassword);

        // Customer data
        $this->request->Set(GatewayRequest::CUSTOMER_FIRSTNAME(), "Joe");
        $this->request->Set(GatewayRequest::CUSTOMER_LASTNAME(), "PHPTester");
        $this->request->Set(GatewayRequest::EMAIL(), "phptest@fakedomain.com");

        // Credit card data
        $this->request->Set(GatewayRequest::CARDNO(), "4111111111111111");
        $this->request->Set(GatewayRequest::EXPIRE_MONTH(), "02");
        $this->request->Set(GatewayRequest::EXPIRE_YEAR(), "2010");
        $this->request->Set(GatewayRequest::CVV2(), "999");

        $time = time();
        $this->customerId = $time . '.PHPTest';
        $this->invoiceId  = $time . '.' . $this->getTestName();

        $this->request->Set(GatewayRequest::MERCHANT_CUSTOMER_ID(), $this->customerId);
        $this->request->Set(GatewayRequest::MERCHANT_INVOICE_ID(), $this->invoiceId);
    }

    abstract function getTestName() : string;

    function getService() : GatewayService
    {
        return clone $this->service;
    }

    function getRequest() : GatewayRequest
    {
        return clone $this->request;
    }

    function getResponse() : GatewayResponse
    {
        return clone $this->response;
    }
}
