<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleShowController extends AbstractController

{
    #[Route('/article/{id}',methods: 'GET')]
    public function ArticleShow(ManagerRegistry $doctrine, int $id): Response
    {
        $articleManager = $doctrine->getManager();
        $article = $doctrine->getRepository(Article::class)->find($id);
        return $this->render('article.html.twig', ['article'=>$article] );
    }

}
