<?php

namespace App\Infrastructure\Tmdb\Api;

class Genres extends Api implements GenresInterface
{
    public function getMovieGenres(array $parameters = [], array $headers = []): array
    {
        $data = $this->get('genre/movie/list', $parameters);

        return $data->toArray();
    }
}
