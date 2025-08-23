<?php

namespace App\Service;

use App\Repository\CarouselImageRepository;

class CarouselImageService
{
    public function __construct(
        private readonly CarouselImageRepository $carouselRepository
    ) {}

    /**
     * Récupération des images du carousel
     */
    public function getCarouselImage() : array{
        try {
            $carousel = $this->carouselRepository->findCarouselImage();
            // Vérifier si la liste est vide
            if(empty($carousel)){
                throw new \Exception("Aucune image trouvée.");
            }
        } catch (\Exception $e) {
            throw new \Exception("Erreur: " . $e->getMessage());
        }
        return $carousel;
    }
}