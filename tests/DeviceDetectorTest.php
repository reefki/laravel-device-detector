<?php

namespace Reefki\DeviceDetector\Tests;

use DeviceDetector\DeviceDetector;
use Illuminate\Http\Request;
use Reefki\DeviceDetector\Device;

class DeviceDetectorTest extends TestCase
{
    /** @test */
    public function it_can_detect_device_from_a_request()
    {
        $request = Request::create('/', 'GET', [], [], [], [
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36',
        ]);

        $this->assertInstanceOf(DeviceDetector::class, $request->device());

        $detector = Device::detectRequest($request);

        $this->assertInstanceOf(DeviceDetector::class, $detector);
    }

    /** @test */
    public function it_can_detect_user_agent_string()
    {
        $device = Device::detect('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36');

        $this->assertInstanceOf(DeviceDetector::class, $device);
    }
}
