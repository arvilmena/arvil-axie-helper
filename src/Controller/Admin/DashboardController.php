<?php

namespace App\Controller\Admin;

use App\Entity\MarketplaceWatchlist;
use App\Entity\Scholar;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(MarketplaceWatchlistCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Axie Infinity Helper');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Homepage', 'fa fa-home', 'homepage');
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Marketplace Watchlist', 'fas fa-list', MarketplaceWatchlist::class);
        yield MenuItem::linkToCrud('Scholars', 'fas fa-list', Scholar::class);
        yield MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt');
    }
}
