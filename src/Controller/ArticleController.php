<?php

namespace App\Controller;

use App\Entity\Article;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/article', name: 'app_article')]
    public function createArticle(ManagerRegistry $doctrine): Response
    {
       $entityManager = $doctrine->getManager();

       $article = new Article();
       $article->setName('New Article');
       $article->setContent('This is new article.');
       $article->setDate(new DateTime());
       $entityManager->persist($article);
       $entityManager ->flush();

       return new Response('new article with ID ' . $article->getId());

    }

    #[Route('article/{id}', name: 'article_show', methods: 'GET')]
    public function articleShow(Article $article): Response
    {
        return $this->render('article/index.html.twig', ['article' => $article]);
    }

}
