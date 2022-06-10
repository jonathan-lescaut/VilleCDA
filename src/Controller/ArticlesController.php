<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use App\Repository\PresentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/articles')]
class ArticlesController extends AbstractController
{
    #[Route('/', name: 'app_articles_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository, PresentationRepository $presentationRepository): Response
    {
        return $this->render('articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'presentation' => $presentationRepository->findAll(),


        ]);
    }

    #[Route('/new', name: 'app_articles_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, ArticlesRepository $articlesRepository, PresentationRepository $presentationRepository, CategoriesRepository $categoriesRepository): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setUser($this->getUser());

            $articlesRepository->add($article, true);

            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/new.html.twig', [
            'article' => $article,
            'presentation' => $presentationRepository->findAll(),
            'articles' => $articlesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_articles_show', methods: ['GET'])]
    public function show(Articles $article,  PresentationRepository $presentationRepository, ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'presentation' => $presentationRepository->findAll(),
            'articles' => $articlesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_articles_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->add($article, true);

            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_articles_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
    }
}
