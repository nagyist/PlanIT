<?php

namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class User {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $fullName;

    public function getId()
    {
    	return $this->id;
    }

    public function setId($id)
    {
    	$this->id = $id;
    	return $this;
    }

    public function getFullName()
    {
    	return $this->fullName;
    }

    public function setFullName($fullName)
    {
    	$this->fullName = $fullName;
    	return $this;
    }
}