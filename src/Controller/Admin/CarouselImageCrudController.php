<?php

namespace App\Controller\Admin;

use App\Entity\CarouselImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CarouselImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarouselImage::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
                ->setLabel('Nom de l\'image'),
            IntegerField::new('orderImage')
                ->setLabel('Ordre de l\'image'),
            BooleanField::new('is_published')
                ->setLabel('Publié'),
            TextField::new('url')
                ->setLabel('Url de l\'image')
                ->hideOnIndex()
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud ->setFormOptions([
            'csrf_protection' => true,
            'csrf_token_id'   => 'carousel_item',
        ]);
    }
}