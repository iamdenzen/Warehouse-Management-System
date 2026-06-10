<?php

namespace App\Services\Xentral;

use Illuminate\Support\Facades\Http;

class XentralClient
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.xentral.base_url');
        $this->apiKey = config('services.xentral.api_key');
    }

    public function get(string $endpoint, array $params = [])
    {
        return Http::withToken($this->apiKey)
            ->get($this->baseUrl . $endpoint, $params)
            ->throw()
            ->json();
    }

    public function post(string $endpoint, array $data = [])
    {
        return Http::withToken($this->apiKey)
            ->post($this->baseUrl . $endpoint, $data)
            ->throw()
            ->json();
    }
}