<?php

namespace App\Controller;

use DateTimeZone;
use App\Entity\Annonce;
use App\Entity\Category;
use App\Entity\User;
use App\Form\AnnonceType;
use App\Repository\UserRepository;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryRepository;
use App\Repository\DepartementRepository;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/annonce")
 */
class AnnonceController extends AbstractController
{
    private $menu_categories;
    public $menu_departement;


    function __construct( CategoryRepository $repoC, DepartementRepository $repoD)
    {
        $this->menu_categories      = $repoC->findAll();
        $this->menu_departement     = $repoD->findAll();

    }


    /**
     * @Route("/", name="annonce_index", methods={"GET"})
     */
    public function index(AnnonceRepository $annonceRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $annonceRepository->findAll();

        $annonce = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            9
        );
        
        return $this->render('annonce/index.html.twig', [
            'annonces'      => $annonce,
            'category'      => $this->menu_categories,
            "departement"   => $this->menu_departement,

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
            // Updated At :
            $now= new \DateTime('now', new DateTimeZone('Europe/Paris'));
            $annonce->setUpdatedAt($now);

            // User : 
            $author = $this->getUser();
            $annonce->setAuthor($author);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            $this->addFlash('success', 'Votre annonce a bien été publié');

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/filter/{id}", name="annonce_type", methods={"GET"})
     */
    public function Annonce_type(AnnonceRepository $annonceRepository): Response
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
            'annonce'   => $annonce,
            'category'  => $this->menu_categories,

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
            // Updated At :
            $now= new \DateTime('now', new DateTimeZone('Europe/Paris'));
            $annonce->setUpdatedAt($now);

            // User : 
            $author = $this->getUser();
            $annonce->setAuthor($author);
            
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('edit', 'Votre annonce a bien été modifié');


            return $this->redirectToRoute('app_account');
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

        $this->addFlash('delete', 'Votre annonce a bien été supprimer');


        return $this->redirectToRoute('app_account');
    }
}
