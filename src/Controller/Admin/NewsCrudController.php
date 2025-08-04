<?php

namespace App\Controller\Admin;

use App\Entity\News;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class NewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return News::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setLabel('Titre'),
            TextareaField::new('content')
                ->setLabel('Contenu')
                ->hideOnIndex(),
            DateField::new('created_at')
                ->setLabel('Date de création'),
            BooleanField::new('is_published')
                ->setLabel('Publié'),
            TextField::new('slug')
                ->setLabel('slug'),
            AssociationField::new('category')
                ->setLabel('Catégorie(s)')
                ->setRequired(true)
                ->formatValue(function($value, $news){
                    $categoryName = [];
                    foreach ($news->getCategory() as $category) {
                        $categoryName[] = $category->__toString();
                    }
                    return implode(', ', $categoryName);
                }),
            TextField::new('image')
                ->setLabel('URL de l\'image')
                ->setHelp('Collez l\'URL d\'une image')
                ->hideOnIndex()    
        ];
    }
    
}
