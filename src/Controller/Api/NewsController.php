<?php

namespace App\Controller\Api;

use App\Service\NewsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NewsController extends AbstractController
{
    public function __construct(
        private readonly NewsService $newsService
    ) {}

    #[Route('/news', name: 'app_news', methods: ['GET'])]
    public function index(): Response
    {
        try {
            $news = $this->newsService->getPublishedNews();

            // format pour l'api 
            $data = [];
            foreach ($news as $new) {
                $data[] = [
                    'id' => $new->getId(),
                    'title' => $new->getTitle(),
                    'content' => $new->getContent(),
                    'image' => $new->getImage(),
                    'slug' => $new->getSlug(),
                    'createdAt' => $new->getCreatedAt()->format('d-m-Y'),
                ];
            }
            return $this->json($data);

        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
