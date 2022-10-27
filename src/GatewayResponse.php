<?php
/*
 * Copyright notice:
 * (c) Copyright 2019 RocketGate
 * All rights reserved.
 *
 * The copyright notice must not be removed without specific, prior
 * written permission from RocketGate.
 *
 * This software is protected as an unpublished work under the U.S. copyright
 * laws. The above copyright notice is not intended to effect a publication of
 * this work.
 * This software is the confidential and proprietary information of RocketGate.
 * Neither the binaries nor the source code may be redistributed without prior
 * written permission from RocketGate.
 *
 * The software is provided "as-is" and without warranty of any kind, express, implied
 * or otherwise, including without limitation, any warranty of merchantability or fitness
 * for a particular purpose.  In no event shall RocketGate be liable for any direct,
 * special, incidental, indirect, consequential or other damages of any kind, or any damages
 * whatsoever arising out of or in connection with the use or performance of this software,
 * including, without limitation, damages resulting from loss of use, data or profits, and
 * whether or not advised of the possibility of damage, regardless of the theory of liability.
 * 
 */

namespace RocketGate\Sdk;

////////////////////////////////////////////////////////////////////////////////
//
//	GatewayResponse() - Object that holds name-value pairs
//			    that describe a gateway response.
//				    
////////////////////////////////////////////////////////////////////////////////
//

class GatewayResponse extends GatewayParameterList
{
//////////////////////////////////////////////////////////////////////
//
//	GatewayResponse() - Constructor for class.
//
//////////////////////////////////////////////////////////////////////
    public function __construct()
    {
//
//	Initialize the parameter list.
//
        parent::__construct();
    }


//////////////////////////////////////////////////////////////////////
//
//	SetResults() - Set the response and reason values.
//
//////////////////////////////////////////////////////////////////////
//
    function SetResults($response, $reason)
    {
        $this->Set(GatewayResponse::RESPONSE_CODE(), $response);
        $this->Set(GatewayResponse::REASON_CODE(), $reason);
    }


//////////////////////////////////////////////////////////////////////
//
//	SetFromXML() - Set the internal parameters using
//		       the contents of an XML document.
//
//////////////////////////////////////////////////////////////////////
//
    function SetFromXML($xmlString)
    {

//
//	Create a parser for the XML.
//
        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);

//
//	Parse the input string.  If there is an error,
//	note it in the response.
//
        if (xml_parse_into_struct($parser, $xmlString, $vals, $index) == 0) {
            $this->Set(GatewayResponse::EXCEPTION(),
                xml_error_string(xml_get_error_code($parser)));
            $this->SetResults(GatewayCodes::RESPONSE_REQUEST_ERROR,
                GatewayCodes::REASON_XML_ERROR);
            xml_parser_free($parser);// Release the parser
            return;  // And we're done
        }

//
//	Loop over the items in the XML document and
//	save them in the response.
//
        foreach ($vals as $val) {// Loop over elements
            if (isset($val['value']))// Is value set?
            {
                $this->Set($val['tag'], $val['value']);
            }// Save in parameters
        }

//
//	Release the parser and quit.
//
        xml_parser_free($parser);// Release the parser
    }


//////////////////////////////////////////////////////////////////////
//
//	Functions that provide constants for name-value pairs.
//
//////////////////////////////////////////////////////////////////////
//
    static function _3DSECURE_DEVICE_COLLECTION_JWT()
    {
        return "_3DSECURE_DEVICE_COLLECTION_JWT";
    }

    static function _3DSECURE_DEVICE_COLLECTION_URL()
    {
        return "_3DSECURE_DEVICE_COLLECTION_URL";
    }

    static function _3DSECURE_STEP_UP_URL()
    {
        return "_3DSECURE_STEP_UP_URL";
    }

    static function _3DSECURE_STEP_UP_JWT()
    {
        return "_3DSECURE_STEP_UP_JWT";
    }

    static function _3DSECURE_VERSION()
    {
        return "_3DSECURE_VERSION";
    }

    static function VERSION_INDICATOR()
    {
        return "version";
    }

    static function ACS_URL()
    {
        return "acsURL";
    }

    static function AUTH_NO()
    {
        return "authNo";
    }

    static function AVS_RESPONSE()
    {
        return "avsResponse";
    }

    static function BALANCE_AMOUNT()
    {
        return "balanceAmount";
    }

    static function BALANCE_CURRENCY()
    {
        return "balanceCurrency";
    }

    static function BANK_RESPONSE_CODE()
    {
        return "bankResponseCode";
    }

    static function BILLING_ADDRESS()
    {
        return "billingAddress";
    }

    static function BILLING_CITY()
    {
        return "billingCity";
    }

    static function BILLING_COUNTRY()
    {
        return "billingCountry";
    }

    static function BILLING_STATE()
    {
        return "billingState";
    }

    static function BILLING_ZIPCODE()
    {
        return "billingZipCode";
    }

    static function CARD_TYPE()
    {
        return "cardType";
    }

    static function CARD_HASH()
    {
        return "cardHash";
    }

    static function CARD_BIN()
    {
        return "cardBin";
    }

    static function CARD_LAST_FOUR()
    {
        return "cardLastFour";
    }

    static function CARD_EXPIRATION()
    {
        return "cardExpiration";
    }

    static function CARD_COUNTRY()
    {
        return "cardCountry";
    }

    static function CARD_REGION()
    {
        return "cardRegion";
    }

    static function CARD_DESCRIPTION()
    {
        return "cardDescription";
    }

    static function CARD_DEBIT_CREDIT()
    {
        return "cardDebitCredit";
    }

    static function CARD_ISSUER_NAME()
    {
        return "cardIssuerName";
    }

    static function CARD_ISSUER_PHONE()
    {
        return "cardIssuerPhone";
    }

    static function CARD_ISSUER_URL()
    {
        return "cardIssuerURL";
    }

    static function CAVV_RESPONSE()
    {
        return "cavvResponse";
    }

    static function CUSTOMER_FIRSTNAME()
    {
        return "customerFirstName";
    }

    static function CUSTOMER_LASTNAME()
    {
        return "customerLastName";
    }

    static function CVV2_CODE()
    {
        return "cvv2Code";
    }

    static function EXCEPTION()
    {
        return "exception";
    }

    static function ECI()
    {
        return "ECI";
    }

    static function EMAIL()
    {
        return "email";
    }

    static function IOVATION_TRACKING_NO()
    {
        return "IOVATIONTRACKINGNO";
    }

    static function IOVATION_DEVICE()
    {
        return "IOVATIONDEVICE";
    }

    static function IOVATION_RESULTS()
    {
        return "IOVATIONRESULTS";
    }

    static function IOVATION_SCORE()
    {
        return "IOVATIONSCORE";
    }

    static function IOVATION_RULE_COUNT()
    {
        return "IOVATIONRULECOUNT";
    }

    static function IOVATION_RULE_TYPE_()
    {
        return "IOVATIONRULETYPE_";
    }

    static function IOVATION_RULE_REASON_()
    {
        return "IOVATIONRULEREASON_";
    }

    static function IOVATION_RULE_SCORE_()
    {
        return "IOVATIONRULESCORE_";
    }

    static function JOIN_DATE()
    {
        return "joinDate";
    }

    static function JOIN_AMOUNT()
    {
        return "joinAmount";
    }

    static function LAST_BILLING_DATE()
    {
        return "lastBillingDate";
    }

    static function LAST_BILLING_AMOUNT()
    {
        return "lastBillingAmount";
    }

    static function LAST_REASON_CODE()
    {
        return "lastReasonCode";
    }

    static function MERCHANT_ACCOUNT()
    {
        return "merchantAccount";
    }

    static function MERCHANT_CUSTOMER_ID()
    {
        return "merchantCustomerID";
    }

    static function MERCHANT_INVOICE_ID()
    {
        return "merchantInvoiceID";
    }

    static function MERCHANT_PRODUCT_ID()
    {
        return "merchantProductID";
    }

    static function MERCHANT_SITE_ID()
    {
        return "merchantSiteID";
    }

    static function PAREQ()
    {
        return "PAREQ";
    }

    static function PROCESSOR_3DS()
    {
        return "PROCESSOR3DS";
    }

    static function REASON_CODE()
    {
        return "reasonCode";
    }

    static function REBILL_AMOUNT()
    {
        return "rebillAmount";
    }

    static function REBILL_DATE()
    {
        return "rebillDate";
    }

    static function REBILL_END_DATE()
    {
        return "rebillEndDate";
    }

    static function REBILL_FREQUENCY()
    {
        return "rebillFrequency";
    }

    static function REBILL_STATUS()
    {
        return "rebillStatus";
    }

    static function RESPONSE_CODE()
    {
        return "responseCode";
    }

    static function ROCKETPAY_INDICATOR()
    {
        return "rocketPayIndicator";
    }

    static function TRANSACT_ID()
    {
        return "guidNo";
    }
    
    static function TRANSACTION_TIME() 
    { 
        return "transactionTime"; 
    }

    static function SCRUB_RESULTS()
    {
        return "scrubResults";
    }

    static function SETTLED_AMOUNT()
    {
        return "approvedAmount";
    }

    static function SETTLED_CURRENCY()
    {
        return "approvedCurrency";
    }
    
    static function RETRIEVAL_ID()
    {
       return "retrievalNo";
    }

    static function SCHEME_TRANSACTION_ID()
    {
        return "schemeTransactionID";
    }

    static function SCHEME_SETTLEMENT_DATE()
    {
        return "schemeSettlementDate";
    }

    static function MERCHANT_ADVICE_CODE()
    {
        return "merchantAdviceCode";
    }

	static function PAYMENT_LINK_URL() 
	{ 
		return "PAYMENT_LINK_URL"; 
	}

	static function PARES()
    {
        return "PARES";
    }

    static function _3DSECURE_DS_TRANSACTION_ID()
    {
        return "_3DSECURE_DS_TRANSACTION_ID";
    }

    static function _3DSECURE_PARESSTATUS()
    {
        return "_3DSECURE_PARESSTATUS";
    }

    static function _3DSECURE_CAVV_UCAF()
    {
        return "_3DSECURE_CAVV_UCAF";
    }

    static function _3DSECURE_CAVV_ALGORITHM()
    {
        return "_3DSECURE_CAVV_ALGORITHM";
    }

    static function _3DSECURE_LOOKUP_SIGNATURE()
    {
        return "_3DSECURE_LOOKUP_SIGNATURE";
    }

    static function _3DSECURE_XID()
    {
        return "_3DSECURE_XID";
    }

    static function _3DSECURE_ACS_TRANSACTION_ID()
    {
        return "_3DSECURE_ACS_TRANSACTION_ID";
    }

    static function _3DSECURE_THREE_DS_SERVER_TRANSACTION_ID()
    {
        return "_3DSECURE_THREE_DS_SERVER_TRANSACTION_ID";
    }

    static function _3DSECURE_LOOKUP_CHALLENGE_INDICATOR()
    {
        return "_3DSECURE_LOOKUP_CHALLENGE_INDICATOR";
    }

    static function _3DSECURE_CHALLENGE_MANDATED_INDICATOR()
    {
        return "_3DSECURE_CHALLENGE_MANDATED_INDICATOR";
    }

    static function _3DSECURE_VERSTATUS()
    {
        return "_3DSECURE_VERSTATUS";
    }

    static function _3DSECURE_LOOKUP_REFERENCE_GUID()
    {
        return "_3DSECURE_LOOKUP_REFERENCE_GUID";
    }

    static function UDF01()
    {
        return "UDF01";
    }

    static function UDF02()
    {
        return "UDF02";
    }

}
