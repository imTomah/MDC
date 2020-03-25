<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Category;
use App\Form\AnnonceType;
use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/annonce")
 */
class AnnonceController extends AbstractController
{
    private $menu_categories;

    function __construct( CategoryRepository $repo)
    {
        $this->menu_categories = $repo->findAll();
    }


    /**
     * @Route("/", name="annonce_index", methods={"GET"})
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
            'category' => $this->menu_categories
        ]);
    }

    /**
     * @Route("/new", name="annonce_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/filter/{id}", name="annonce_filter", methods={"GET"})
     */
    public function Annonce_Filter(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/annonce_by_category.html.twig', [
            'annonces' => $annonceRepository->findAll(),
            'category' => $this->menu_categories
        ]);
    }

    /**
     * @Route("/{id}", name="annonce_show", methods={"GET"})
     */
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'category' => $this->menu_categories

        ]);
    }

    /**
     * @Route("/{id}/edit", name="annonce_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="annonce_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Annonce $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_index');
    }
}
