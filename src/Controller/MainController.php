<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Category;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public $menu_categories;

    function __construct(CategoryRepository $repo) {
        $this->menu_categories = $repo->findAll();
    }
    
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'MainController',
            'menu_categories' => $this->menu_categories,
        ]);
    }

    /**
     * @Route("/filter/{id}", name="annonce_filter")
     */
    public function annonce_filter($id, CategoryRepository $repo, AnnonceRepository $annonceRepository)
    {
        $category = $repo->find($id);
        $filtre = $id;
        return $this->render('annonce/annonce_by_category.html.twig', [
            'annonces' => $category->getAnnonces(),
            'filtre' => $id,
            "category" => $this->menu_categories,
            ]);
    }
    
    /**
     * @Route("/filter/{id}", name="annonce_filter")
     */
    public function link_footer($id, CategoryRepository $repo, AnnonceRepository $annonceRepository)
    {
        $category = $repo->find($id);
        $annonce = $category->getAnnonces();
        return $this->render('component/footer.html.twig', [
            'annonces' => $category->getAnnonces(),
            "category" => $this->menu_categories,
            ]);
    }
}
