<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Votes;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\VotesRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CreateArticleController extends AbstractController
{
    #[route('/admin/newArticle', name: 'article_create')]
    public function CreateArticle(ArticleRepository $articleRepository, Request $request, VotesRepository $votesRepository): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $data = $form->getData();
            $article = new Article();
            $article ->setName($data['name']);
            $article->setContent($data['content']);
            $article->setDate($data['date']);
            $vote = new Votes();
            $vote ->setDownVote(0);
            $vote->setUpVote(0);
            $vote->setArticle($article);

            $articleRepository ->save($article, true);
            $votesRepository ->save($vote, true);

            $this->addFlash(
                'notice','New Article has been created.');

            return $this->redirectToRoute('app_index');
        }
        return $this->render('create_article/createArticle.html.twig', ['form'=>$form->createView()]);
    }



}
