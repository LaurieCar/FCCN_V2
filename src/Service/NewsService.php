<?php

namespace App\Service;

use App\Repository\NewsRepository;

class NewsService
{
    public function __construct(
        private readonly NewsRepository $newsRepository
    ) {}

    /**
     * Récupération des dernières actualités publiées
     */
    public function getPublishedNews() : array{
        try {
            $news = $this->newsRepository->findPublishedNews();
            // Vérifier si la liste est vide
            if(empty($news)){
                throw new \Exception("Aucune actualité publiée trouvée.");
            }
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération des actualités");
        }
        return $news;
    }
}