<?php

namespace BoncoinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="BoncoinBundle\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var int
     *
     * @ORM\Column(name="viewCounter", type="integer", options={"default"=0} )
     */
    private $viewCounter;

    /**
     * Annonce constructor.
     * @param string $title
     * @param string $location
     * @param $price
     * @param $url
     * @param int $viewCounter
     */
    public function __construct(string $title, string $location, $price, $url, $viewCounter = 0)
    {
        $this->title = $title;
        $this->location = $location;
        $this->price = $price;
        $this->url = $url;
        $this->viewCounter = $viewCounter;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Annonce
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Annonce
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Annonce
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getViewCounter(): int
    {
        return $this->viewCounter;
    }

    /**
     * @param int $viewCounter
     */
    public function setViewCounter(int $viewCounter)
    {
        $this->viewCounter = $viewCounter;
    }

    /**
     * Increment view counter from one view
     */
    public function incrementView()
    {
        $this->viewCounter++;
    }

    /**
     * Return unique id generated from unique url
     * @return string
     */
    public function getUniqueId()
    {
        return base64_encode($this->getUrl());
    }

}
