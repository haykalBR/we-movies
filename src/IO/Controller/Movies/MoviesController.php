<?php

namespace IO\Controller\Movies;

use App\Infrastructure\Tmdb\Api\GenresInterface;
use App\Infrastructure\Tmdb\Api\MoviesInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    public function __construct(private readonly MoviesInterface $moviesInterface, private readonly GenresInterface $genresInterface)
    {
    }

    #[Route('/movies', name: 'index_movies', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        $response = $this->genresInterface->getMovieGenres()['genres'];

        return $this->render('movies/index.html.twig', ['genres' => $response]);
    }

    #[Route('/api/movies/{genre}', name: 'api_movies', options: ['expose' => true], methods: [Request::METHOD_GET])]
    #[OA\Response(
        response: 200,
        description: 'Returns a list of movies',
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Return Message error ',
    )]
    #[OA\Tag(name: 'movies')]
    public function movies(int $genre): JsonResponse
    {
        try {
            $parameters = [
              'with_genres' => $genre,
              'sort_by' => 'vote_average.desc',
            ];
            $movies = $this->moviesInterface->getMovies($parameters);

            return $this->json($movies, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Returns a list of movies by search keyword',
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Return Message error ',
    )]
    #[OA\Tag(name: 'movies')]
    #[Route('/api/search/movies/{keyword}', name: 'api_search_movies', options: ['expose' => true], methods: [Request::METHOD_GET])]
    public function searchMovies(string $keyword): JsonResponse
    {
        try {
            $parameters = [
                'query' => $keyword,
            ];
            $response = $this->moviesInterface->searchMovies($parameters);

            return $this->json($response, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Return a movie details with video ',
    )]
    #[OA\Response(
        response: Response::HTTP_BAD_REQUEST,
        description: 'Return Message error ',
    )]
    #[OA\Tag(name: 'movies')]
    #[Route('/api/movie/{id}', name: 'api_get_movie', options: ['expose' => true], methods: [Request::METHOD_GET])]
    public function movie(int $id): JsonResponse
    {
        try {
            $parameters = [
                'append_to_response' => 'videos',
            ];
            $response = $this->moviesInterface->getMovie($id, $parameters);

            return $this->json($response, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
