<?php


namespace App\Controller;


use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuthorController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /** @var AuthorRepository $authorRepository */
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * * @Route("/authors", name="autnors")
     */
    public function authors(): \Symfony\Component\HttpFoundation\Response
    {
        $authors = $this->authorRepository->findAll();
        return $this->render('author/all.html.twig', ['authors' => $authors]);
    }
}