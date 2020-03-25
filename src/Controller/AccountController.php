<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController
{
    public $menu_categories;

    function __construct_menu(CategoryRepository $repo) {
        $this->menu_categories = $repo->findAll();
        return $this->render('component/navbar.html.twig', [
            'menu_categories' => $this->menu_categories,
            ]);
    }
    
    /**
     * @Route("/account", name="app_account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'menu_categories' => $this->menu_categories,            
            
        ]);
    }
}
