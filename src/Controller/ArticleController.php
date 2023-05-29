<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\EvaulationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ArticleController extends AbstractController
{
    #[Route('article/{id}', name: 'article_show')]
    public function articleShow(Request $request, CommentRepository $commentRepository, Article $article): Response
    {
      
        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $NewComment = new Comment();
            $NewComment->setName($data['name']);
            $NewComment->setContent($data['comment']);
            $NewComment->setArticle($article);

            $commentRepository->save($NewComment, true);


            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }
        $comment = $commentRepository->findBy(['article' => $article]);
        return $this->render('article/index.html.twig', ['commentForm' => $form->createView(), 'article' => $article, 'comments' => $comment]);
    }

    #[Route('/article/evaulate', name: 'article_evaulate')]
    public function evaulate(ArticleRepository $articleRepository,){


    }

    #[Route('admin/article/delete/{id}', name: 'article_delete')]
    public function articleDelete(ArticleRepository $articleRepository, CommentRepository $commentRepository, int $id): Response
    {
        $article = $articleRepository->find($id);
        $comments = $commentRepository->findBy(['article' => $article]);
        foreach ($comments as $comment) {
            $commentRepository->remove($comment);
        }
        $articleRepository->remove($article, true);

        $this->addFlash(
            'notice',
            'Article with id ' . $id . ' has been deleted.'
        );
        return $this->redirectToRoute('app_index');
    }

    #[Route('admin/article/edit/{id}', name: 'article_edit')]
    public function articleEdit(Article $article, Request $request, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $articleRepository->save($article, true);
            //$this->addFlash('Article updated.');

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }
        return $this->render('article/editArticle.html.twig', ['form' => $form->createView()]);
    }

    #[route('article/{id}/comment/{commentId}', name: 'comment_delete')]
    public function deleteComment(int $commentId, Article $article, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->find($commentId);
        $commentRepository->remove($comment, true);

        return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
    }


}
