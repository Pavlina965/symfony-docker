<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route(name: 'app_index')]
    public function getArticles(ManagerRegistry $doctrine): Response
    {

        $article = $doctrine->getRepository(Article::class)->findAll();
        return $this->render("index/index.html.twig",['articles'=>$article]);
    }

}
