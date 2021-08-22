<?php

namespace App\Controller\Admin;

use App\Entity\Scholar;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ScholarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Scholar::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
