<?php


namespace App\Controller;

use App\Entity\Author;
use App\Entity\Books;
use App\Form\BooksType;
use App\Repository\BooksRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BooksController extends AbstractController
{
    /** @var BooksRepository $booksRepository */
    private $booksRepository;

    public function __construct(BooksRepository $booksRepository)
    {
        $this->booksRepository = $booksRepository;
    }

    /**
     * @Route("/books", name="books")
     */
    public function books()
    {
        $books = $this->booksRepository->findAll();
        return $this->render('books/allBooks.html.twig', ['books' => $books]);
    }

    /**
     * @Route("/book/{id}", name="book")
     */
    public function book(Books $book)
    {
        return $this->render('books/book.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/books/new", name="new_book")
     */
    public function newBook(Request $request)
    {
        {
            $book = new Books();
            $author = new Author();
            $var = $request->request->get('books');
            //$cover = $request->files;

            $form = $this->createForm(BooksType::class, $book);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $book = $form->getData();
                $book->setName($var['name']);
                $book->setDescription($var['description']);
                $book->setPublicationYear($var['publicationYear']);
                // $book->setCover($cover['tmp']);

                $author->setName($var['authors']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($book);
                $em->flush();
                return $this->redirectToRoute('new_book');
            }
            return $this->render('books/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
}