<?php

namespace App\Infrastructure\Tmdb\Api;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiInterface
{
    public function get(string $path, array $parameters = []): ResponseInterface;
}
