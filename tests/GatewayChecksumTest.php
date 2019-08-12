<?php

namespace RocketGate\Sdk\Tests;

use PHPUnit\Framework\TestCase;
use RocketGate\Sdk\GatewayChecksum;

class GatewayChecksumTest extends TestCase
{
    public function testSetVersion()
    {
        GatewayChecksum::SetVersion();
        $this->assertNotContains(
            "m",
            GatewayChecksum::$versionNo,
            "Modified version. Current checksum " . GatewayChecksum::$checksum .
            " has to match base " . GatewayChecksum::$baseChecksum . "."
        );
    }
}
