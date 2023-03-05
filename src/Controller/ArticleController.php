<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }


    #[Route('article/{id}', name: 'article_show')]
    public function articleShow(Request $request, Article $article): Response
    {
        $em = $this->doctrine->getManager();
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $NewComment = new Comment();
            $NewComment->setName($data['name']);
            $NewComment->setContent($data['comment']);
            $NewComment->setDate($data['date']);
            $NewComment->setArticle($article);

            $em->persist($NewComment);
            $em->flush();


            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }
        $comment =$this->doctrine->getRepository(Comment::class)->findBy(['article'=>$article]);
        return $this->render('article/index.html.twig', ['commentForm' => $form->createView(), 'article' => $article, 'comments'=>$comment]);
    }

    #[
        Route('article/delete/{id}', name: 'article_delete')]
    public function articleDelete(int $id): Response
    {
        $entityManager = $this->doctrine->getManager();
        $article = $this->doctrine->getRepository(Article::class)->find($id);
        $comments =$this->doctrine->getRepository(Comment::class)->findBy(['article'=>$article]);
        foreach ($comments as $comment ){
            $entityManager->remove($comment);
        }
        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash(
            'notice', 'Article with id ' . $id . ' has been deleted.'
        );

        return $this->redirectToRoute('app_index');
    }

    #[Route('article/edit/{id}', name: 'article_edit')]
    public function articleEdit(Article $article, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($article);
            $em->flush();

            //$this->addFlash('Article updated.');

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }
        return $this->render('article/editArticle.html.twig', ['form' => $form->createView()]);
    }
    #[route('article/{id}/comment/{commentId}', name:'comment_delete')]
    public function deleteComment(int $commentId, Article $article): Response
    {
        $em = $this->doctrine->getManager();
        $comment = $this->doctrine->getRepository(Comment::class)->find($commentId);
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('article_show',['id'=>$article->getId()]);
    }
}
