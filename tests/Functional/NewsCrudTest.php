<?php

namespace App\Tests;

use App\Entity\Admin;
use App\Entity\News;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class NewsCrudTest extends WebTestCase
{
    // simule un client connecté en admin
    private function loginClient(): KernelBrowser
    {
        // création client du test
        $client = static::createClient();
        // Recupération entity manager
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        // Récupération de l'admin par son email
        $admin = $entityManager->getRepository(Admin::class)->findOneBy(['email' => 'admin1@fccn.com']);
        // Si admin introuvable
        $this->assertNotNull($admin, 'Administrateur de test introuvable');
        // Authentifiaction de l'admin
        $client->loginUser($admin);
        return $client;
    }

    // TEST 1 : CREER UNE NEWS 
    public function testCreateNews(): void
    {
        // crée un client déjà loggé 
        $client = $this->loginClient();
        // Récupère l'entity manager pour accéder à la bdd
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        // récupère une catégorie pour l'associer a la news
        $category = $entityManager->getRepository(Category::class)->findOneBy([]);

        $crawler = $client->request('GET', '/admin/news/new');
        $this->assertResponseIsSuccessful();
        
        // Données du test
        $title = 'Nouvelle Actualité créée (test)';
        $content = "Contenu de l'actualité crée (test)";
        $form = $crawler->selectButton('Create')->form([
            'News[title]' => $title,
            'News[content]' => $content,
            'News[slug]' => 'test-news' . uniqid(),
            'News[created_at]' => (new \DateTimeImmutable())->format('Y-m-d H:i'),
            'News[is_published]' => true,
            'News[category]' => [(string)$category->getId()],
        ]);
        // soumission du formulaire
        $client->submit($form);
        $this->assertResponseRedirects(); // vérifie la redirection
        $crawler = $client->followRedirect(); // suit la redirection vers la page index

        // Verif: la news est bien créée en BDD
        $entityManager->clear();
        $createdNews = $entityManager->getRepository(News::class)->findOneBy(['title' => $title]);
        $this->assertNotNull($createdNews, 'La news devrait être créée en base');
    }

    // TEST 2: EDITER UNE NEWS
    public function testEditNews(): void
    {
        $client = $this->loginClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        // News existante
        $category = $entityManager->getRepository(Category::class)->findOneBy([]);
        $news = new News();
        $news->setTitle('Titre avant édition (test)');
        $news->setContent('Contenu avant édition (test)');
        $news->setSlug('avant-édition' .uniqid());
        $news->setCreatedAt(new \DateTimeImmutable());
        $news->setIsPublished(true);
        $news->addCategory($category);
        $entityManager->persist($news);
        $entityManager->flush();

        // Page édition 
        $crawler = $client->request('GET', '/admin/news/'.$news->getId().'/edit');
        $this->assertResponseIsSuccessful();

        // Modifier le titre et le contenu
        $newTitle = 'Titre apres édition (test)';
        $newContent = 'Contenu apres édition';
        $form = $crawler->selectButton('Save changes')->form([
            'News[title]' => $newTitle,
            'News[content]' => $newContent,
        ]);
        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();

        // Vérifier en bdd
        $entityManager->clear();
        $newEdit = $entityManager->getRepository(News::class)->find($news->getId());
        $this->assertSame($newTitle, $newEdit->getTitle());
        $this->assertSame($newContent, $newEdit->getContent());
    }

    // TEST 3 : SUPPRIMER UNE NEWS
    public function testDeleteNews(): void
    {
        $client = $this->loginClient();
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        // News a supprimer
        $category = $entityManager->getRepository(Category::class)->findOneBy([]);
        $news = new News();
        $news->setTitle("News a supprimer (test)");
        $news->setContent("Contenu a supprimer");
        $news->setSlug("a-supprimer" .uniqid());
        $news->setCreatedAt(new \DateTimeImmutable());
        $news->setIsPublished(true);
        $news->addCategory($category);
        $entityManager->persist($news);
        $entityManager->flush();

        $id = $news->getId();

        // Supprimer directement via entityManager
        $entityManager->remove($news);
        $entityManager->flush();

        // Vérifier que la news n'existe plus en bdd
        $entityManager->clear();
        $this->assertNull($entityManager->getRepository(News::class)->find($id));
    }
}
