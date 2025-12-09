<?php

namespace Reefki\DeviceDetector\Tests;

use DeviceDetector\DeviceDetector;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use Reefki\DeviceDetector\Device;

class DeviceDetectorTest extends TestCase
{
    #[Test]
    public function it_can_detect_device_from_a_request(): void
    {
        $request = Request::create('/', 'GET', [], [], [], [
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36',
        ]);

        $this->assertInstanceOf(DeviceDetector::class, $request->device());

        $detector = Device::detectRequest($request);

        $this->assertInstanceOf(DeviceDetector::class, $detector);
    }

    #[Test]
    public function it_can_detect_user_agent_string(): void
    {
        $device = Device::detect('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36');

        $this->assertInstanceOf(DeviceDetector::class, $device);
    }

    #[Test]
    public function it_can_detect_browser_information(): void
    {
        $device = Device::detect('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36');

        $client = $device->getClient();

        $this->assertIsArray($client);
        $this->assertEquals('Chrome', $client['name']);
        $this->assertEquals('browser', $client['type']);
    }

    #[Test]
    public function it_can_detect_operating_system(): void
    {
        $device = Device::detect('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36');

        $os = $device->getOs();

        $this->assertIsArray($os);
        $this->assertEquals('Mac', $os['name']);
    }

    #[Test]
    public function it_can_detect_desktop_device(): void
    {
        $device = Device::detect('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36');

        $this->assertTrue($device->isDesktop());
        $this->assertFalse($device->isMobile());
        $this->assertFalse($device->isTablet());
        $this->assertFalse($device->isBot());
    }

    #[Test]
    public function it_can_detect_mobile_device(): void
    {
        $device = Device::detect('Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1');

        $this->assertTrue($device->isMobile());
        $this->assertFalse($device->isDesktop());
        $this->assertFalse($device->isTablet());
        $this->assertFalse($device->isBot());
        $this->assertEquals('Apple', $device->getBrandName());
        $this->assertEquals('iPhone', $device->getModel());
    }

    #[Test]
    public function it_can_detect_tablet_device(): void
    {
        $device = Device::detect('Mozilla/5.0 (iPad; CPU OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1');

        $this->assertTrue($device->isTablet());
        $this->assertFalse($device->isDesktop());
        $this->assertFalse($device->isBot());
        $this->assertEquals('Apple', $device->getBrandName());
        $this->assertEquals('iPad', $device->getModel());
    }

    #[Test]
    public function it_can_detect_bot(): void
    {
        $device = Device::detect('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');

        $this->assertTrue($device->isBot());
        $this->assertFalse($device->isDesktop());
        $this->assertFalse($device->isMobile());

        $bot = $device->getBot();

        $this->assertIsArray($bot);
        $this->assertEquals('Googlebot', $bot['name']);
    }

    #[Test]
    public function it_can_handle_empty_user_agent(): void
    {
        $device = Device::detect('');

        $this->assertInstanceOf(DeviceDetector::class, $device);
        $this->assertFalse($device->isBot());
    }

    #[Test]
    public function it_can_detect_device_from_request_without_user_agent(): void
    {
        $request = Request::create('/', 'GET');

        $device = Device::detectRequest($request);

        $this->assertInstanceOf(DeviceDetector::class, $device);
    }
}
