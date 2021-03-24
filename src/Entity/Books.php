<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @Table(name="books",
 *     schema="public"
 * )
 */
class Books
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
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
     * @ORM\Column (type="string", nullable=false)
     */
    private $cover;
    /**
     * @ORM\Column(type="datetime")
     */
    private $publication_year;


    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
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
     * @param mixed $publication_year
     */
    public function setPublicationYear($publication_year): void
    {
        $this->publication_year = $publication_year;
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
    public function getAuthor()
    {
        return $this->author;
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
        return $this->publication_year;
    }
}
