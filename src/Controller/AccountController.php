<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController
{
    public $annonces;
    public $menu_categories;

    function __construct_menu(CategoryRepository $repo, AnnonceRepository $repoA) {
        $this->menu_categories = $repo->findAll();
        $this->annonces        = $repoA->findAll();
    }
    
    /**
     * @Route("/account", name="app_account")
     */
    public function index(AnnonceRepository $repoA)
    {   
        $annonces = $repoA->findAll();
        return $this->render('account/index.html.twig', [
            'menu_categories' => $this->menu_categories, 
            'annonces'        => $annonces,           
        ]);
    }
}
