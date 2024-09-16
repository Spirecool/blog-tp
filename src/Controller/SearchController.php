<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArticleRepository;

class SearchController extends AbstractController
{
    // Récupère la valeur de la requête 'search'
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $search = $request->query->get('search');
        $articles = $articleRepository->findArticles($search);
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'articles' => $articles
        ]);
    }
}


