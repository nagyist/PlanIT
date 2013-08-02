<?php

namespace Flyers\PlanITBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Flyers\PlanITBundle\Entity\UserRepository")
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Constraints\NotNull
     * @Constraints\NotBlank
     * 
     * @Expose
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

}