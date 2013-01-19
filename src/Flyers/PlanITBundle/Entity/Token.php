<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flyers\PlanITBundle\Entity\Token
 */
class Token
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $value
     */
    private $value;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Token
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @var Flyers\PlanITBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param Flyers\PlanITBundle\Entity\User $user
     * @return Token
     */
    public function setUser(\Flyers\PlanITBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Flyers\PlanITBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}