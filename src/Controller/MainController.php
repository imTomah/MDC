<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Category;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryRepository;
use App\Repository\DepartementRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public $menu_categories;
    public $menu_departement;
    public $annonces;
    public $annoncesFruits;
    public $annoncesLegumes;
    public $annoncesOutils;


    function __construct(CategoryRepository $repoC, AnnonceRepository $repoA, DepartementRepository $repoD) {
        $this->menu_categories          = $repoC->findAll();
        $this->menu_departement         = $repoD->findAll();
        $this->annonces                 = $repoA->findAll();
        $this->annoncesFruits           = $repoA->findBy(array('Type' => 'Fruits' ));
        $this->annoncesLegumes          = $repoA->findBy(array('Type' => 'Legumes'));
        $this->annoncesOutils           = $repoA->findBy(array('Type' => 'Outils' ));
    }
    
    /**
     * @Route("/", name="accueil")
     */
    public function index(CategoryRepository $repo, AnnonceRepository $annonceRepository)
    {
        $category = $repo->findAll();
        return $this->render('index.html.twig', [
            'controller_name'       => 'MainController',
            'menu_categories'       => $this->menu_categories,
            'menu_departement'      => $this->menu_departement,
            'annoncesFruits'        => $this->annoncesFruits,
            'annoncesLegumes'       => $this->annoncesLegumes,
            'annoncesOutils'        => $this->annoncesOutils,
            'annonces'              => $annonceRepository->findAll(),
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
}
