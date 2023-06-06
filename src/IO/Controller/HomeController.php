<?php

declare(strict_types=1);

namespace IO\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'home', methods: ['GET'])]
    public function index(HttpClientInterface $api): Response
    {
        return $this->json('h');
    }
}
