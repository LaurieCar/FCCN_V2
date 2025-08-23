<?php

namespace App\Controller\Api;

use App\Service\CarouselImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CarouselImageController extends AbstractController
{
    public function __construct(
        private readonly CarouselImageService $carouselService
    ) {}

    #[Route('/carousel', name: 'app_carousel', methods: ['GET'])]
    public function index(): Response
    {
        try {
            $images = $this->carouselService->getCarouselImage();

            // format pour l'api 
            $data = [];
            foreach ($images as $image) {
                $data[] = [
                    'id' => $image->getId(),
                    'name' => $image->getName(),
                    'orderImage' => $image->getOrderImage(),
                    'url' => $image->getUrl(),
                ];
            }
            return $this->json($data);

        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}