<?php

namespace App\Controller;

use DateTimeZone;
use App\Entity\ArticleBlog;
use App\Form\ArticleBlogType;
use App\Repository\ArticleBlogRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/article/blog")
 */
class ArticleBlogController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_blog")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin(ArticleBlogRepository $articleBlogRepository)
    {
        return $this->render('article_blog/admin.html.twig', [
            'article_blogs' => $articleBlogRepository->findAll(),
        ]);
    }

    
    /**
     * @Route("/", name="article_blog_index", methods={"GET"})
     */
    public function index(ArticleBlogRepository $articleBlogRepository): Response
    {
        return $this->render('article_blog/index.html.twig', [
            'article_blogs' => $articleBlogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="article_blog_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $articleBlog = new ArticleBlog();
        $form = $this->createForm(ArticleBlogType::class, $articleBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now= new \DateTime('now', new DateTimeZone('Europe/Paris'));
            $articleBlog->setUpdatedAt($now);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articleBlog);
            $entityManager->flush();

            return $this->redirectToRoute('article_blog_index');
        }

        return $this->render('article_blog/new.html.twig', [
            'article_blog' => $articleBlog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_blog_show", methods={"GET"})
     */
    public function show(ArticleBlog $articleBlog, ArticleBlogRepository $articleBlogRepository): Response
    {
        return $this->render('article_blog/show.html.twig', [
            'article_blog'  => $articleBlog,
            'article_blogs' => $articleBlogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="article_blog_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, ArticleBlog $articleBlog): Response
    {
        $form = $this->createForm(ArticleBlogType::class, $articleBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $now= new \DateTime('now', new DateTimeZone('Europe/Paris'));
            $articleBlog->setUpdatedAt($now);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_blog_index');
        }

        return $this->render('article_blog/edit.html.twig', [
            'article_blog'  => $articleBlog,
            'form'          => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="article_blog_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, ArticleBlog $articleBlog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleBlog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($articleBlog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_blog_index');
    }
}
