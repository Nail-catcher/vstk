<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MapBoxService
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $url;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $token;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $version;

    /**
     * MapBoxService constructor.
     */
    public function __construct()
    {
        $this->url = config('services.mapbox.url');
        $this->token = config('services.mapbox.token');
    }

    /**
     * @param string $profile
     * @param array $coordinates
     * @return string
     */
    public function getOptimizedTrips(string $profile, array $coordinates): string
    {
        $url = $this->url('optimized-trips', $profile, 'v1', $this->getCoordinates($coordinates));
        $response = Http::get($url);
        return $response->body();
    }

    /**
     * @param string $endpoint
     * @param string $profile
     * @param string $version
     * @param string $coordinates
     * @param array $options
     * @return string
     */
    protected function url(string $endpoint, string $profile, string $version, string $coordinates, array $options = []): string
    {
        $segments = [
            $this->url,
            $endpoint,
            $version,
            $profile,
            $coordinates
        ];

        return 'https://' . implode('/', $segments) . '?access_token=' . $this->token;
    }

    /**
     * @param array $coordinates
     * @return string
     */
    protected function getCoordinates(array $coordinates): string
    {
        return implode(';', $coordinates);
    }

    /**
     * @param array $coordinates
     * @return array
     * @throws \Exception
     */
    public function getDirectionDriving(array $coordinates): array
    {
        $url = $this->url('directions', 'mapbox/driving', 'v5', '');
        $response = Http::asForm()
            ->post($url, [
                'coordinates' => $this->getCoordinates($coordinates)
            ]);
        $data = $response->json();
        if ($response->status() !== 200) {
            throw new \Exception($data['message']);
        }
        return $data;
    }
}
