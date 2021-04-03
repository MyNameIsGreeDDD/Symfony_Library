<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 * @Table(name="books")
 */
class Books
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private ?int $id;
    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $name;
    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $author;
    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $description;
    /**
     * @ORM\Column (type="string", nullable=true)
     */
    private $cover;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $publicationYear;


    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @param mixed $publicationYear
     */
    public function setPublicationYear($publicationYear): void
    {
        $this->publicationYear = $publicationYear;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @return mixed
     */
    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }
}
