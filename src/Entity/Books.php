<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
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
    private $description;
    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $cover;
    /**
     * @ORM\Column(type="integer")
     */
    private $publicationYear;
    /**
     * @var ArrayCollection
     *  Many Books have Many Authors.
     * @ORM\ManyToMany(targetEntity="App\Entity\Author", mappedBy="books")
     */
    private $authors;


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
}
