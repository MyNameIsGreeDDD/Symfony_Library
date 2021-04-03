<?php


namespace App\Controller;


use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use App\Services\CoverService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BookController extends AbstractController
{
    /** @var BooksRepository $booksRepository */
    private BooksRepository $booksRepository;

    public function __construct(BooksRepository $booksRepository)
    {
        $this->booksRepository = $booksRepository;
    }

    /**
     * @Route("/books", name="books")
     */
    public function books(): Response
    {
        $books = $this->booksRepository->findAll();
        return $this->render('books/all.html.twig', ['books' => $books]);
    }

    /**
     * @Route("/book/{id}", name="book")
     * @param Books $book
     * @return Response
     */
    public function book(Books $book): Response
    {
        return $this->render('books/book.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @param Books $book
     * @param Request $request
     * @param CoverService $coverService
     * @return Response
     * @Route ("/books/{id}/edit", name="book_edit")
     */
    public function edit(Books $book, Request $request, CoverService $coverService): Response
    {
        $form = $this->createForm(BooksType::class,$book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $var = $request->request->get('books');
            $cover = $request->files->get('books');

            if (!empty($cover['cover'])) {
                $uploadDir = $this->getParameter('cover_directory');
                $dirForDeleteOldCover = $uploadDir . substr($book->getCover(), -15);
                unlink($dirForDeleteOldCover);
                $path = $coverService->uploadCover($cover, $uploadDir);

                $book->setCover($path);
            }

            $book->setName($var['name']);
            $book->setAuthor($var['author']);
            $book->setDescription($var['description']);
            $book->setPublicationYear($var['publicationYear']);


            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('books/book.html.twig', array(
                'book' => $book,
            ));
        }
        return $this->render('books/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/books/new", name="new_book")
     * @param Request $request
     * @param CoverService $coverService
     * @return Response
     */
    public function newBook(Request $request, CoverService $coverService): Response
    {
        {
            $book = new Books();

            $form = $this->createForm(BooksType::class, $book);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $var = $request->request->get('books');
                $cover = $request->files->get('books');

                $uploadDir = $this->getParameter('cover_directory');
                $path = $coverService->uploadCover($cover, $uploadDir);

                $book = $form->getData();
                $book->setName($var['name']);
                $book->setAuthor($var['author']);
                $book->setDescription($var['description']);
                $book->setPublicationYear($var['publicationYear']);
                $book->setCover($path);

                $em = $this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();
                return $this->render('books/book.html.twig', array(
                    'book' => $book,
                ));
            }
            return $this->render('books/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/books/{id}/delete", name="book_delete")
     * @param Books $book
     * @return RedirectResponse
     */
    public function delete(Books $book): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('books');
    }
}