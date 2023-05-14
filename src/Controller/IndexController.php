<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class IndexController extends AbstractController
{
    public function __construct(private Security $security,)
    {
    }


    #[Route(name: 'app_index')]
    public function articlesUser(ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findAll();
        return $this->render("index/index.html.twig", ['articles' => $article]);
    }

    #[Route('/admin',name: 'admin')]
    public function articlesAdmin(ArticleRepository $articleRepository):Response
    {
        $article=$articleRepository->findAll();
        return $this->render("index/admin_index.html.twig", ['articles'=>$article]);
    }

}
