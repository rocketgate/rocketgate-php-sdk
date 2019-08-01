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
//	GatewayParameterList() - Object that holds name-value pairs
//				 that describe a request or response.
//
////////////////////////////////////////////////////////////////////////////////
//

class GatewayParameterList
{
    var $params;// Name value pairs

//////////////////////////////////////////////////////////////////////
//
//	GatewayParameterList() - Constructor for class.
//
//////////////////////////////////////////////////////////////////////
//
    public function __construct()
    {
        $this->params = array();// Allocate an array
    }


//////////////////////////////////////////////////////////////////////
//
//	Reset() - Clear the elements in the array
//
//////////////////////////////////////////////////////////////////////
//
    function Reset()
    {
        $this->params = array();
    }


//////////////////////////////////////////////////////////////////////
//
//	Get() - Return the value associated with a key.
//
//////////////////////////////////////////////////////////////////////
//
    function Get($key)
    {
        return array_key_exists($key, $this->params) ? trim($this->params[$key]) : null;
    }


//////////////////////////////////////////////////////////////////////
//
//	Set() - Set the value associated with a key.
//
//////////////////////////////////////////////////////////////////////
//
    function Set($key, $value)
    {
        $this->Clear($key);// Remove existing value
        if (is_float($value)) {// Floating point?
            $value = (string)$value;// Convert to string
            $value = str_replace(",", ".", $value);// Clean value
        }
        $this->params[$key] = $value;// Save new value
    }


//////////////////////////////////////////////////////////////////////
//
//	Clear() - Remove a key value.
//
//////////////////////////////////////////////////////////////////////
//
    function Clear($key)
    {
        if (array_key_exists($key, $this->params))// Does it exist?
        {
            unset($this->params[$key]);
        }// Clear it
    }


//////////////////////////////////////////////////////////////////////
//
//	DebugPrint() - Dump the contents of the object
//		       for debugging.
//
//////////////////////////////////////////////////////////////////////
//
    function DebugPrint()
    {
        print_r($this->params);
    }
}
