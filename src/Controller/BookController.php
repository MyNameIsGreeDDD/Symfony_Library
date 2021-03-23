<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/books", name="books")
     */
    public function books()
    {
        $books = [
            'book_1' => [
                'name' => 'Book1',
                'author' => 'GreeDDD'
            ],
            'book_2' => [
                'name' => 'Book2',
                'author' => 'GreeDDD'
            ]
        ];
        return $this->render('books.html.twig', ['books' => $books]);
    }

}