<?php

////////////////////////////////////////////////////////////////////////////////
//
//	GatewayChecksum() - Static class for checksum and version.
//
////////////////////////////////////////////////////////////////////////////////
//
namespace RocketGate\Sdk;

class GatewayChecksum
{
    private const VERSION = "P8.18";
    public static $checksum = "";
    public static $baseChecksum = "9dc5bd4416a9c3b17f4f9f7f5c9b1c5e";
    public static $versionNo = GatewayChecksum::VERSION;

//////////////////////////////////////////////////////////////////////
//
//	Set the client version number.
//
//////////////////////////////////////////////////////////////////////
//
    static function SetVersion()
    {
        $dirName = dirname(__FILE__);
        $baseString = md5_file($dirName . "/GatewayService.php") .
            md5_file($dirName . "/GatewayRequest.php") .
            md5_file($dirName . "/GatewayResponse.php") .
            md5_file($dirName . "/GatewayParameterList.php") .
            md5_file($dirName . "/GatewayCodes.php");
        GatewayChecksum::$checksum = md5($baseString);
        print "checksum: " . GatewayChecksum::$checksum . "\n";
        if (GatewayChecksum::$checksum != GatewayChecksum::$baseChecksum) {
            GatewayChecksum::$versionNo = GatewayChecksum::VERSION . "m";
        }
    }
}
