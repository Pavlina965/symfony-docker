<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditArticleController extends AbstractController
{
    #[Route('/edit/article', name: 'app_edit_article')]
    public function index(): Response
    {
        return $this->render('edit_article/createArticle.html.twig', [
            'controller_name' => 'EditArticleController',
        ]);
    }
}
