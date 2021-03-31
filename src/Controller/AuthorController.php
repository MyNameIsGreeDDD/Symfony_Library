<?php


namespace App\Controller;


use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuthorController extends AbstractController
{
    /** @var AuthorRepository $authorRepository */
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * * @Route("/authors", name="authors")
     */
    public function authors(): Response
    {
        $authors = $this->authorRepository->findAll();
        return $this->render('author/all.html.twig', ['authors' => $authors]);
    }

    /**
     * @Route ("/author/{id}/delete", name="author_delete")
     * @param $author
     * @return RedirectResponse
     */
    public function delete(Author $author): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('authors');
    }

    /**
     * @Route ("/author/{id}/edit", name="author_edit")
     * @param Author $author
     * @param Request $request
     * @return Response
     */
    public function edit(Author $author, Request $request): Response
    {
        $form = $this->createForm(AuthorType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $var = $request->request->get('authors');
            //Реализация редактирования


            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('author/author.html.twig', array(
                'author' => $author,
            ));
        }
        return $this->render('author/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/authors/new", name="new_author")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        {
            $author = new Author();


            $form = $this->createForm(AuthorType::class, $author);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $var = $request->request->get('author');

                $author = $form->getData();
                $author->setName($var['name']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($author);
                $em->flush();
                return $this->render('author/author.html.twig', array(
                    'author' => $author,
                ));
            }
            return $this->render('author/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
}