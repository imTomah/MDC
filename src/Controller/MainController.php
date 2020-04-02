<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Category;
use App\Repository\AnnonceRepository;
use App\Repository\ArticleBlogRepository;
use App\Repository\CategoryRepository;
use App\Repository\DepartementRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public $menu_categories;
    public $menu_departement;
    public $annonces;

    function __construct(CategoryRepository $repoC, AnnonceRepository $repoA, DepartementRepository $repoD, ArticleBlogRepository $repoBlog) {
        $this->menu_categories          = $repoC->findAll();
        $this->menu_departement         = $repoD->findAll();
        $this->annonces                 = $repoA->findAll();
        $this->article_blogs            = $repoBlog->findAll();

    }
    
    /**
     * @Route("/", name="accueil")
     */
    public function index(CategoryRepository $repo, AnnonceRepository $annonceRepository, ArticleBlogRepository $articleBlogRepository)
    {
        $category = $repo->findAll();
        return $this->render('index.html.twig', [
            'controller_name'       => 'MainController',
            'menu_categories'       => $this->menu_categories,
            'menu_departement'      => $this->menu_departement,
            'annonces'              => $annonceRepository->findAll(),
            'article_blogs'         => $articleBlogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/type/{id}", name="annonce_type")
     */
    public function annonce_type($id, CategoryRepository $repo, AnnonceRepository $annonceRepository, DepartementRepository $repoD)
    {   
        $departement    = $repoD->find($id);
        $category       = $repo->find($id);
        $filtre         = $id;
        return $this->render('annonce/annonce_by_category.html.twig', [
            'annonces'      => $category->getAnnonces(),
            'filtre'        => $id,
            "category"      => $this->menu_categories,
            "departement"   => $this->menu_departement,
            ]);
    }

    /**
     * @Route("/departement/{id}", name="annonce_departement")
     */
    public function annonce_departement($id, CategoryRepository $repo, AnnonceRepository $annonceRepository, DepartementRepository $repoD)
    {   
        $departement    = $repoD->find($id);
        $filtre         = $id;
        return $this->render('annonce/annonce_by_category.html.twig', [
            'annonces'      => $departement->getAnnonces(),
            'filtre'        => $id,
            "category"      => $this->menu_categories,
            "departement"   => $this->menu_departement
            ]);
    }

    public function annonce_account(AnnonceRepository $repoA)
    {
        return $this->render('account/index.html.twig', [
            'annonces'        => $repoA->findAll(),           
        ]);
    }
}
