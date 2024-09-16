<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\Comment1Type;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article/{id}/comment')]
class CommentController extends AbstractController
{
    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request,Article $article, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        // Mettre automatiquement la date du jour
        $comment->setCreatedAt(new DateTimeImmutable());
        // Mettre automatiquement le nom de l'user connecté à l'application
        $comment->setUser($this->getUser());
        $comment->setArticle($article);
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            // return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute(
                'app_article_show', 
                ['id' => $article->getId()], 
                Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }
}

