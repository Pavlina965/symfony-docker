<?php

namespace App\Controller;

use App\Entity\Article;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use http\Exception\BadMethodCallException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/article', name: 'article_create')]
    public function createArticle(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $article = new Article();
        $article->setName('New fcking Article');
        $article->setContent('This is really new article.');
        $article->setDate(new DateTime());
        $entityManager->persist($article);
        $entityManager->flush();

        return $this->redirectToRoute('app_index');
        //return new Response('new article with ID ' . $article->getId());

    }

    #[Route('article/{id}', name: 'article_show', methods: 'GET')]
    public function articleShow(Article $article): Response
    {

        return $this->render('article/index.html.twig', ['article' => $article]);
    }

    #[Route('article/delete/{id}', name: 'article_delete')]
    public function articleDelete(ManagerRegistry $doctrine, Article $article, int $id): Response
    {
        $entityManager=$doctrine->getManager();
        $article=$doctrine->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash(
            'notice','Article with id ' .$id.' has been deleted.'
        );

        return $this->redirectToRoute('app_index');
    }

}
