<?php

namespace App\Infrastructure\Tmdb\Api;

interface MoviesInterface
{
    public function getMovies(array $parameters = []): array;

    public function searchMovies(array $parameters = []): array;

    public function getMovie(int $id, array $parameters = []): array;
}
