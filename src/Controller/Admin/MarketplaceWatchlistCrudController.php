<?php

namespace App\Controller\Admin;

use App\Entity\MarketplaceWatchlist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MarketplaceWatchlistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MarketplaceWatchlist::class;
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
