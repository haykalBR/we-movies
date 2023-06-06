<?php

namespace App\Infrastructure\Tmdb\Api;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Api implements ApiInterface
{
    public function __construct(private readonly string $baseUrl, private readonly string $token)
    {
    }

    public function get(string $path, array $parameters = []): ResponseInterface
    {
        $httpClient = HttpClient::create();

        $query = array_merge([
            'language' => 'en',
        ], $parameters);
        $headers = [
            'Authorization' => "Bearer {$this->token}",
            'accept' => 'application/json',
        ];
        $response = $httpClient->request(Request::METHOD_GET, $this->baseUrl.$path, [
            'headers' => $headers,
            'query' => $query,
        ]);

        return $response;
    }
}
