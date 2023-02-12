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



    #[Route('article/{id}', name: 'article_show', methods: 'GET')]
    public function articleShow(Article $article): Response
    {

        return $this->render('article/createArticle.html.twig', ['article' => $article]);
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
