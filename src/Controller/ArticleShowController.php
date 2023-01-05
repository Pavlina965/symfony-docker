<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleShowController extends AbstractController

{
    #[Route('/article/{id}', name: 'article.detail',methods: 'GET')]
    public function ArticleShow(Article $article): Response
    {

        return $this->render('article.html.twig', ['article'=>$article] );
    }

}
