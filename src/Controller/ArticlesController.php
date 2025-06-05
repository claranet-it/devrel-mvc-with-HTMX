<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $articles = json_decode(file_get_contents(__DIR__ . '/../Data/articles.json'), true);
        $perPage = 10;
        $page = max(1, (int)$request->query->get('page', 1));
        $offset = ($page - 1) * $perPage;
        $paginatedArticles = array_slice($articles, $offset, $perPage);
        $totalPages = (int) ceil(count($articles) / $perPage);
        $nextPage = ($page < $totalPages) ? $page + 1 : null;
        $previousPage = ($page > 1) ? $page - 1 : null;

        return $this->render('articles/articles.html.twig', [
            'articles' => $paginatedArticles,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'nextPage' => $nextPage,
            'previousPage' => $previousPage,
        ]);
    }

    #[Route('/articles/page', name: 'app_articles_page', methods: ['GET'])]
    public function page(Request $request): Response
    {
        $articles = json_decode(file_get_contents(__DIR__ . '/../Data/articles.json'), true);
        $perPage = 10;
        $page = max(1, (int)$request->query->get('page', 1));
        $offset = ($page - 1) * $perPage;
        $paginatedArticles = array_slice($articles, $offset, $perPage);
        $totalPages = (int) ceil(count($articles) / $perPage);
        $nextPage = ($page < $totalPages) ? $page + 1 : null;
        $previousPage = ($page > 1) ? $page - 1 : null;

        return $this->render('articles/articles_table_and_pagination.html.twig', [
            'articles' => $paginatedArticles,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'nextPage' => $nextPage,
            'previousPage' => $previousPage,
        ]);
    }

    #[Route('/articles/{id}', name: 'app_articles_delete', methods: ['DELETE'])]
    public function delete(Request $request): Response
    {
        return new Response();
    }
}