<?php


namespace App\Controller;


use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        return $this->render('books/allBooks.html.twig', ['books' => $books]);
    }

    /**
     * @Route("/book/{id}", name="book")
     * @param Books $book
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
     * @return Response
     */
    public function newBook(Request $request): Response
    {
        {
            $book = new Books();


            $form = $this->createForm(BooksType::class, $book);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $var = $request->request->get('books');
                $cover = $request->files->get('books');
                $cover = $cover['cover']->getRealPath();
                $uploadDir = $this->getParameter('cover_directory');
                $path = $uploadDir . 'CoverBook-' . $var['name'];
                move_uploaded_file($cover, $path);

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
            return $this->render('books/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }


}