<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class NewsFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array 
    {
        return [CategoryFixtures::class];
    }
    public function load(ObjectManager $manager): void
    {
        // création de la variable qui contient les données
        $faker = Factory::create('fr_FR');
        $faker->seed(200);

        // Récupération des catégories 
        $categories = $manager->getRepository(Category::class)->findAll();

        // Boucle qui itère 9 news factices
        for($i=0; $i<5; $i++) {
            $new = new News();
            // Génération d'une news factice
            $new->setTitle($faker->sentence(3));
            $new->setContent($faker->text());
            $new->setSlug($faker->unique()->slug());
            $new->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-60 days', 'now')));
            $new->setIsPublished(true);

            // ajout des catégories aléatoires créés dans CategoryFixtures
            foreach ($faker->randomElements($categories, $faker->numberBetween(1, 3)) as $category) {
                $new->addCategory($category);
            }

            $manager->persist($new);
        }
        
        // Création d'une news "repère" 
        $newRef = new News();
        $newRef->setTitle('News de référence');
        $newRef->setContent('Contenu de référence');
        $newRef->setSlug('slug-reference');
        $newRef->setCreatedAt(new \DateTimeImmutable('now'));
        $newRef->setIsPublished(true);

        foreach (array_slice($categories, 0, min(2, count($categories))) as $category) {
            $newRef->addCategory($category);
        }
        $manager->persist($newRef);

        $manager->flush();
    }
}