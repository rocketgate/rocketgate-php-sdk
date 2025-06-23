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

class GatewayCodes {
//////////////////////////////////////////////////////////////////////
//
//	Declaration of static response codes.
//
//////////////////////////////////////////////////////////////////////
//
    const RESPONSE_SUCCESS       = 0;    // Function succeeded
    const RESPONSE_BANK_FAIL     = 1;    // Bank decline/failure
    const RESPONSE_RISK_FAIL     = 2;    // Risk failure
    const RESPONSE_SYSTEM_ERROR  = 3;    // Server/recoverable error
    const RESPONSE_REQUEST_ERROR = 4;    // Invalid request

//////////////////////////////////////////////////////////////////////
//
//	Declaration of static reason codes.
//
//////////////////////////////////////////////////////////////////////
//
    const REASON_SUCCESS = 0;// Function succeeded

    const REASON_NOMATCHING_XACT             = 100;
    const REASON_CANNOT_VOID                 = 101;
    const REASON_CANNOT_CREDIT               = 102;
    const REASON_CANNOT_TICKET               = 103;
    const REASON_DECLINED                    = 104;
    const REASON_DECLINED_OVERLIMIT          = 105;
    const REASON_DECLINED_CVV2               = 106;
    const REASON_DECLINED_EXPIRED            = 107;
    const REASON_DECLINED_CALL               = 108;
    const REASON_DECLINED_PICKUP             = 109;
    const REASON_DECLINED_EXCESSIVE          = 110;
    const REASON_DECLINED_INVALID_CARDNO     = 111;
    const REASON_DECLINED_INVALID_EXPIRATION = 112;
    const REASON_BANK_UNAVAILABLE            = 113;
    const REASON_EMPTY_BATCH                 = 114;
    const REASON_BATCH_REJECTED              = 115;
    const REASON_DUPLICATE_BATCH             = 116;
    const REASON_DECLINED_AVS                = 117;
    const REASON_NO_BATCH_AVAILABLE          = 118;
    const REASON_USER_BUSY                   = 119;
    const REASON_INVALID_REGION              = 120;
    const REASON_UNKNOWN_CARRIER             = 121;
    const REASON_CARRIER_REQUIRED            = 122;
    const REASON_USER_DECLINED               = 123;
    const REASON_USER_TIMEOUT                = 124;
    const REASON_NETWORK_MISMATCH            = 125;
    const REASON_CELLPHONE_BLACKLISTED       = 126;
    const REASON_FULL_FAILURE                = 127;
    const REASON_PARTIAL_FAILURE             = 128;
    const REASON_DECLINED_PIN                = 129;
    const REASON_DECLINED_AVS_AUTOVOID       = 150;
    const REASON_DECLINED_CVV2_AUTOVOID      = 151;
    const REASON_INVALID_TICKET_AMT          = 152;
    const REASON_NO_SUCH_FILE                = 153;
    const REASON_INTEGRATION_ERROR           = 154;
    const REASON_DECLINED_CAVV               = 155;
    const REASON_UNSUPPORTED_CARDTYPE        = 156;
    const REASON_DECLINED_RISK               = 157;
    const REASON_INVALID_DEBIT_ACCOUNT       = 158;
    const REASON_INVALID_USER_DATA           = 159;
    const REASON_AUTH_HAS_EXPIRED            = 160;
    const REASON_PREVIOUS_HARD_DECLINE       = 161;
    const REASON_MERCHACCT_LIMIT             = 162;
    const REASON_DECLINED_CAVV_AUTOVOID      = 163;
    const REASON_BANK_INVALID_TRANSACTION    = 165;
    const REASON_CVV2_REQUIRED               = 167;
    const REASON_INVALID_TAX_ID              = 169;

    const REASON_RISK_FAIL                        = 200;
    const REASON_CUSTOMER_BLOCKED                 = 201;
    const REASON_3DSECURE_AUTHENTICATION_REQUIRED = 202;
    const REASON_3DSECURE_NOT_ENROLLED            = 203;
    const REASON_3DSECURE_UNAVAILABLE             = 204;
    const REASON_3DSECURE_REJECTED                = 205;
    const REASON_RISK_PREPAID_CARD                = 206;
    const REASON_RISK_AVS_VS_ISSUER               = 207;
    const REASON_DUPLICATE_MEMBERSHIP             = 208;
    const REASON_DUPLICATE_CARD                   = 209;
    const REASON_DUPLICATE_EMAIL                  = 210;
    const REASON_EXCEEDED_MAX_PURCHASE            = 211;
    const REASON_DUPLICATE_PURCHASE               = 212;
    const REASON_VELOCITY_CUSTOMER                = 213;
    const REASON_VELOCITY_CARD                    = 214;
    const REASON_VELOCITY_EMAIL                   = 215;
    const REASON_IOVATION_DECLINE                 = 216;
    const REASON_VELOCITY_DEVICE                  = 217;
    const REASON_DUPLICATE_DEVICE                 = 218;
    const REASON_1CLICK_SOURCE                    = 219;
    const REASON_TOO_MANY_CARDS                   = 220;
    const REASON_AFFILIATE_BLOCKED                = 221;
    const REASON_TRIAL_ABUSE                      = 222;
    const REASON_3DSECURE_BYPASS                  = 223;
    const REASON_NEWCARD_NODEVICE                 = 224;
    const REASON_3DSECURE_INITIATION              = 225;
	const REASON_3DSECURE_FRICTIONLESS_FAILED_AUTH = 227;
	const REASON_3DSECURE_SCA_REQUIRED            = 228;
    const REASON_3DSECURE_CARDHOLDER_CANCEL       = 229;
    const REASON_3DSECURE_ACS_TIMEOUT             = 230;
    const REASON_3DSECURE_INVALID_CARD            = 231;
    const REASON_3DSECURE_INVALID_TRANSACTION     = 232;
    const REASON_3DSECURE_ACS_TECHNICAL_ISSUE     = 233;
    const REASON_3DSECURE_EXCEEDS_MAX_CHALLENGES  = 234;
    const REASON_DNS_FAILURE               = 300;
    const REASON_UNABLE_TO_CONNECT         = 301;
    const REASON_REQUEST_XMIT_ERROR        = 302;
    const REASON_RESPONSE_READ_TIMEOUT     = 303;
    const REASON_RESPONSE_READ_ERROR       = 304;
    const REASON_SERVICE_UNAVAILABLE       = 305;
    const REASON_CONNECTION_UNAVAILABLE    = 306;
    const REASON_BUGCHECK                  = 307;
    const REASON_UNHANDLED_EXCEPTION       = 308;
    const REASON_SQL_EXCEPTION             = 309;
    const REASON_SQL_INSERT_ERROR          = 310;
    const REASON_BANK_CONNECT_ERROR        = 311;
    const REASON_BANK_XMIT_ERROR           = 312;
    const REASON_BANK_READ_ERROR           = 313;
    const REASON_BANK_DISCONNECT_ERROR     = 314;
    const REASON_BANK_TIMEOUT_ERROR        = 315;
    const REASON_BANK_PROTOCOL_ERROR       = 316;
    const REASON_ENCRYPTION_ERROR          = 317;
    const REASON_BANK_XMIT_RETRIES         = 318;
    const REASON_BANK_RESPONSE_RETRIES     = 319;
    const REASON_BANK_REDUNDANT_RESPONSES  = 320;
    const REASON_WEBSERVICE_FAILURE        = 321;
    const REASON_PROCESSOR_BACKEND_FAILURE = 322;
    const REASON_JSON_FAILURE              = 323;
    const REASON_GPG_FAILURE               = 324;
    const REASON_3DS_SYSTEM_FAIULRE        = 325;
    const REASON_USE_DIFFERENT_SERVER      = 326;

    const REASON_XML_ERROR                   = 400;
    const REASON_INVALID_URL                 = 401;
    const REASON_INVALID_TRANSACTION         = 402;
    const REASON_INVALID_CARDNO              = 403;
    const REASON_INVALID_EXPIRATION          = 404;
    const REASON_INVALID_AMOUNT              = 405;
    const REASON_INVALID_MERCHANT_ID         = 406;
    const REASON_INVALID_MERCHANT_ACCOUNT    = 407;
    const REASON_INCOMPATIBLE_CARDTYPE       = 408;
    const REASON_NO_SUITABLE_ACCOUNT         = 409;
    const REASON_INVALID_REFGUID             = 410;
    const REASON_INVALID_ACCESS_CODE         = 411;
    const REASON_INVALID_CUSTDATA_LENGTH     = 412;
    const REASON_INVALID_EXTDATA_LENGTH      = 413;
    const REASON_INVALID_CUSTOMER_ID         = 414;
    const REASON_INVALID_CURRENCY            = 418;
    const REASON_INCOMPATIBLE_CURRENCY       = 419;
    const REASON_INVALID_REBILL_ARGS         = 420;
    const REASON_INVALID_PHONE               = 421;
    const REASON_INVALID_COUNTRY_CODE        = 422;
    const REASON_INVALID_BILLING_MODE        = 423;
    const REASON_INCOMPATABLE_COUNTRY        = 424;
    const REASON_INVALID_TIMEOUT             = 425;
    const REASON_INVALID_ACCOUNT_NO          = 426;
    const REASON_INVALID_ROUTING_NO          = 427;
    const REASON_INVALID_LANGUAGE_CODE       = 428;
    const REASON_INVALID_BANK_NAME           = 429;
    const REASON_INVALID_BANK_CITY           = 430;
    const REASON_INVALID_CUSTOMER_NAME       = 431;
    const REASON_INVALID_BANKDATA_LENGTH     = 432;
    const REASON_INVALID_PIN_NO              = 433;
    const REASON_INVALID_PHONE_NO            = 434;
    const REASON_INVALID_ACCOUNT_HOLDER      = 435;
    const REASON_INCOMPATIBLE_DESCRIPTORS    = 436;
    const REASON_INVALID_REFERRAL_DATA       = 437;
    const REASON_INVALID_SITEID              = 438;
    const REASON_DUPLICATE_INVOICE_ID        = 439;
    const REASON_EXISTING_MEMBERSHIP         = 440;
    const REASON_INVOICE_NOT_FOUND           = 441;
    const REASON_INVALID_BATCH_DURATION      = 442;
    const REASON_MISSING_CUSTOMER_ID         = 443;
    const REASON_MISSING_CUSTOMER_NAME       = 444;
    const REASON_MISSING_CUSTOMER_ADDRESS    = 445;
    const REASON_MISSING_CVV2                = 446;
    const REASON_MISSING_PARES               = 447;
    const REASON_NO_ACTIVE_MEMBERSHIP        = 448;
    const REASON_INVALID_CVV2                = 449;
    const REASON_INVALID_3D_DATA             = 450;
    const REASON_INVALID_CLONE_DATA          = 451;
    const REASON_REDUNDANT_SUSPEND_OR_RESUME = 452;
    const REASON_INVALID_PAYINFO_TRANSACT_ID = 453;
    const REASON_INVALID_CAPTURE_DAYS        = 454;
    const REASON_INVALID_SUBMERCHANT_ID      = 455;
    const REASON_INVALID_COF_FRAMEWORK       = 458;
    const REASON_INVALID_REFERENCE_SCHEME_TRANSACTION = 459;
    const REASON_INVALID_CUSTOMER_ADDRESS    = 460;
    const REASON_INVALID_BUILD_PAYMENT_LINK_REQUEST = 462;
    const REASON_INVALID_SS_NUMBER          = 463;
    const REASON_INVALID_CUSTOMER_EMAIL     = 465;
    const REASON_MISSING_CUSTOMER_EMAIL     = 466;
    const REASON_MISSING_CUSTOMER_PHONE     = 467;
    const REASON_INVALID_CUSTOMER_IP        = 468;
    const REASON_MISSING_CUSTOMER_IP        = 469;
    const REASON_INVALID_APPLE_PAY_TOKEN    = 471;
}
