<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use http\Exception\BadMethodCallException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }


    #[Route('article/{id}', name: 'article_show', methods: 'GET')]
    public function articleShow(Article $article): Response
    {

        return $this->render('article/index.html.twig', ['article' => $article]);
    }

    #[Route('article/{id}/delete', name: 'article_delete')]
    public function articleDelete(Article $article, int $id): Response
    {
        $entityManager = $this->doctrine->getManager();
        $article = $this->doctrine->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash(
            'notice', 'Article with id ' . $id . ' has been deleted.'
        );

        return $this->redirectToRoute('app_index');
    }

    #[Route('article/{id}/edit', name: 'article_edit')]
    public function articleEdit(Article $article, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($article);
            $em ->flush();

            //$this->addFlash('Article updated.');

            return $this->redirectToRoute('article_show', ['id'=>$article->getId()]);
        }
        return $this->render('article/editArticle.html.twig', ['form' => $form->createView()]);
    }
}
