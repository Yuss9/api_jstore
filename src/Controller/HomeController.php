<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Entity\Category;


class HomeController  extends AbstractController
{
    private $repo;
    private $repoCategory;

    public function __construct(ArticleRepository $repoArticle, CategoryRepository $repoCategory)
    {
        $this->repo = $repoArticle;
        $this->repoCategory = $repoCategory;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        //on avait en param avec la ligne en dessous  EntityManagerInterface $doctrine
        //$repo = $doctrine->getRepository(Article::class);
        $categories = $this->repoCategory->findAll();
        //dd($categories);

        $articles = $this->repo->findAll();
        return $this->render("home/index.html.twig", [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Article $article): Response
    {
        //on avait en param avec la ligne en dessous  EntityManagerInterface $doctrine
        //$repo = $doctrine->getRepository(Article::class);
        //$article = $this->repo->find($id);

        if (!$article) {
            return $this->redirectToRoute('home');
        }
        return $this->render("show/index.html.twig", [
            'article' => $article,
        ]);
    }

    #[Route('/showArticles/{id}', name: 'show_article')]
    public function showArticle(?Category $category): Response
    {
        if ($category) {
            $articles = $category->getArticles()->getValues();
        } else {
            return $this->redirectToRoute('home');
        }
        $categories = $this->repoCategory->findAll();
        return $this->render("home/index.html.twig", [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
}
