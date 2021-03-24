<?php


namespace App\Controller;

use App\Entity\Books;
use App\Repository\BooksRepository;
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
     * @Route("/books/{id}", name="book")
     */
    public function book(Books $book)
    {
        return $this->render('books/book.html.twig', [
            'book' => $book
        ]);
    }

}