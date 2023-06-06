<?php

namespace App\Infrastructure\Tmdb\Api;

class Movies extends Api implements MoviesInterface
{
    /**
     * Discover movies by type of data like average rating, number of votes, genres.
     */
    public function getMovies(array $parameters = []): array
    {
        $data = $this->get('discover/movie', $parameters);

        return $data->toArray();
    }

    public function searchMovies(array $parameters = []): array
    {
        $data = $this->get('search/movie', $parameters);

        return $data->toArray();
    }

    public function getMovie(int $id, array $parameters = []): array
    {
        $data = $this->get("movie/{$id}", $parameters);

        return $data->toArray();
    }
}
