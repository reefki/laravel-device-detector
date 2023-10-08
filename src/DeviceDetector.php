<?php

namespace Reefki\DeviceDetector;

use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector as MatomoDeviceDetector;
use Illuminate\Http\Request;

class DeviceDetector
{
    /**
     * Create a new instance.
     *
     * @param  \Reefki\DeviceDetector\CacheRepository  $cache
     * @return void
     */
    public function __construct(
        protected CacheRepository $cache
    ) {
    }

    /**
     * Detect the device using the user agent and headers.
     *
     * @param  string  $userAgent
     * @param  array<string, mixed>  $headers
     * @return \DeviceDetector\DeviceDetector
     */
    public function detect(string $userAgent, array $headers = []): MatomoDeviceDetector
    {
        $clientHints = ClientHints::factory(
            headers: $headers,
        );

        $detector = new MatomoDeviceDetector(
            userAgent: $userAgent,
            clientHints: $clientHints,
        );

        $detector->setCache(
            cache: $this->cache,
        );

        $detector->parse();

        return $detector;
    }

    /**
     * Detect the device for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \DeviceDetector\DeviceDetector
     */
    public function detectRequest(Request $request): MatomoDeviceDetector
    {
        return $this->detect(
            userAgent: $request->userAgent() ?? '',
            headers: (array) $request->server(),
        );
    }
}
