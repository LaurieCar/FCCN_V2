<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminCrudController extends AbstractCrudController
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {}

    public static function getEntityFqcn(): string
    {
        return Admin::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Administrateur')
            ->setEntityLabelInPlural('Administrateurs')
            ->setFormOptions([
                'csrf_protection' => false,
                'csrf_token_id'   => 'admin_item',
            ]);
            //->setEntityPermission('ROLE_SUPER_ADMIN'); // Admin uniquement gérés pas le super admin
    }
    
    public function configureFields(string $pageName): iterable
    {
        $firstname = TextField::new('firstname', 'Prénom');
        $lastname = TextField::new('lastname', 'Nom');
        $email = EmailField::new('email', 'Email');

        $password = TextField::new('plainPassword', 'Mot de passe')
            ->setFormType(PasswordType::class)
            ->onlyOnForms();
        // password required only to create    
        if($pageName === Crud::PAGE_NEW) {
            $password = $password->setRequired(true);
        }
        else {
            $password === $password->setRequired(false);
        }

        $roles = ChoiceField::new('roles', 'Rôles')
            ->setChoices([
                'Administrateur' => 'ROLE_ADMIN',
                'Super Administrateur' => 'ROLE_SUPER_ADMIN'
            ])
            ->allowMultipleChoices()
            ->renderExpanded(false)
            ->hideOnIndex();

        return [
            $firstname,
            $lastname,
            $email,
            $password,
            $roles
        ];
    }

    // Transformation du mot de passe en hash sécurisé
    public function hashPasswordIsProvided(Admin $admin) : void
    {
        $plainPassword = $admin->getPlainPassword(); // Récupère la saisie du formulaire
        if($plainPassword) {
            $hash = $this->passwordHasher->hashPassword($admin, $plainPassword); // hashe le mdp
            $admin->setPassword($hash); // Stocke le hash du mot de passe en bdd
            $admin->setPlainPassword(null); // on vide le plain password 
        }
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Admin) {
            $this->hashPasswordIsProvided($entityInstance);
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
       if ($entityInstance instanceof Admin) {
            $this->hashPasswordIsProvided($entityInstance);
        }
        parent::updateEntity($entityManager, $entityInstance); 
    }
    
}
