<?php

namespace App\Controller\Admin;

use App\Entity\News;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_EDIT, Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud ->setFormOptions([
            'csrf_protection' => true,
            'csrf_token_id'   => 'news_item',
        ]);
    }
    
}
