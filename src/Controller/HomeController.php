<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use App\Repository\PresentationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository, PresentationRepository $presentationRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'presentation' => $presentationRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/admin', name: 'app_home_admin')]
    public function indexAdmin(ArticlesRepository $articlesRepository, CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('home/admin.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }
}
