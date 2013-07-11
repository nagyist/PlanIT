<?php

namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Album {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $artist;

    /** @ORM\Column(type="string") */
    protected $title;

    public function getId()
    {
    	return $this->id;
    }

    public function setId($id)
    {
    	$this->id = $id;
    	return $this;
    }

    public function getArtist()
    {
    	return $this->artist;
    }

    public function setArtist($artist)
    {
    	$this->artist = $artist;
    	return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
}