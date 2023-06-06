<?php

namespace App\Infrastructure\Tmdb\Api;

interface GenresInterface
{
    public function getMovieGenres(array $parameters = [], array $headers = []): array;
}
