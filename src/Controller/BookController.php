<?php


namespace App\Controller;


use App\Entity\Books;
use App\Form\BookAuthorEditType;
use App\Form\BookCoverEditType;
use App\Form\BookDescriptionEditType;
use App\Form\BookNameEditType;
use App\Form\BookPublicationYearEditType;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use App\Services\CoverService;
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
     * @Route("/books/new", name="new_book")
     * @param Request $request
     * @param CoverService $coverService
     * @return Response
     */
    public
    function newBook(Request $request, CoverService $coverService): Response
    {
        {
            $book = new Books();

            $form = $this->createForm(BooksType::class);
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

    /**
     * @param Books $book
     * @param Request $request
     * @Route("/books/{id}/editAuthor", name="author_edit")
     * @return Response
     */
    public function editAuthor(Books $book, Request $request): Response
    {

        $form = $this->createForm(BookAuthorEditType::class, $book);
        $form->handleRequest($request);

        $var = $request->request->get('book_author_edit');

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setAuthor($var['author']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('books/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Books $book
     * @param Request $request
     * @Route("/books/{id}/editName", name="name_edit")
     */
    public function editName(Books $book, Request $request): Response
    {
        $form = $this->createForm(BookNameEditType::class, $book);
        $form->handleRequest($request);

        $var = $request->request->get('book_name_edit');

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setName($var['name']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('books/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Books $book
     * @param Request $request
     * @Route("/books/{id}/editDescription", name="description_edit")
     */
    public function editDescription(Books $book, Request $request): Response
    {
        $form = $this->createForm(BookDescriptionEditType::class, $book);
        $form->handleRequest($request);

        $var = $request->request->get('book_description_edit');

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setDescription($var['description']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('books/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Books $book
     * @param Request $request
     * @Route("/books/{id}/editPublicationYear", name="publication_year_edit")
     */
    public function editPublicationYear(Books $book, Request $request): Response
    {
        $form = $this->createForm(BookPublicationYearEditType::class, $book);
        $form->handleRequest($request);

        $var = $request->request->get('book_publication_year_edit');

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setPublicationYear($var['publicationYear']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('books/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Books $book
     * @param Request $request
     * @param CoverService $coverService
     * @return Response
     * @Route("/books/{id}/editCover", name="cover_edit")
     */
    public function editCover(Books $book, Request $request, CoverService $coverService): Response
    {
        $form = $this->createForm(BookCoverEditType::class);
        $form->handleRequest($request);

        $cover = $request->files->get('book_cover_edit');

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadDir = $this->getParameter('cover_directory');
            $dirForDeleteOldCover = $uploadDir . substr($book->getCover(), -15);
            unlink($dirForDeleteOldCover);
            $path = $coverService->uploadCover($cover, $uploadDir);

            $book->setCover($path);

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('books/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/books/search", name="book_search")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response
    {
        $query = $request->query->get('q');
        $books = $this->booksRepository->searchByQuery($query);

        return $this->render('books/query_book.html.twig', [
            'books' => $books
        ]);
    }

}