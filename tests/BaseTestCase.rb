require 'minitest/autorun'
require_relative '../GatewayService'
require_relative '../GatewayRequest'
require_relative '../GatewayResponse'

module RocketGate
  class BaseTestCase < Minitest::Test

    def setup
      @merchantId = 1

      @merchantPassword = 'testpassword'

      @service = GatewayService.new
      @service.SetTestMode true

      @response = GatewayResponse.new
      @request = GatewayRequest.new

      # Merchant data
      @request.Set(GatewayRequest::MERCHANT_ID, @merchantId)
      @request.Set(GatewayRequest::MERCHANT_PASSWORD, @merchantPassword)

      # Customer data
      @request.Set(GatewayRequest::CUSTOMER_FIRSTNAME, "Joe")
      @request.Set(GatewayRequest::CUSTOMER_LASTNAME, "RubyTester")
      @request.Set(GatewayRequest::EMAIL, "rubytest@fakedomain.com")

      # Credit card data
      @request.Set(GatewayRequest::CARDNO, "4111111111111111")
      @request.Set(GatewayRequest::EXPIRE_MONTH, "02")
      @request.Set(GatewayRequest::EXPIRE_YEAR, "2010")
      @request.Set(GatewayRequest::CVV2, "999")

      t = Time.now.to_i.to_s

      @customerId = t + '.RubyTest'
      @invoiceId = t + '.' + get_test_name

      @request.Set(GatewayRequest::MERCHANT_CUSTOMER_ID, @customerId)
      @request.Set(GatewayRequest::MERCHANT_INVOICE_ID, @invoiceId)
    end

    def get_test_name
      raise 'implement'
    end
  end
end
