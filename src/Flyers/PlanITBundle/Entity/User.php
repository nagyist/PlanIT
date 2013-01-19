<?php

/*
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
  
 * « Copyright 2012 BEN GHMISS Nassim »  
 * 
 */

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Flyers\PlanITBundle\Entity\User
 * @UniqueEntity(
 *    fields="username",
 *    message="Email already used"
 * )
 */
class User implements UserInterface
{

    /**
     * @var string $username
     * @Assert\Email(
     *    message = "The mail address is not valid",
     *    checkMX = true
     * )
     */
    private $username;

    /**
     * @var string $password
     * @Assert\MinLength(
     *    limit=4,
     *    message = "The password must be at least {{ limit }} characters" 
     * )
     */
    private $password;

    /**
     * @var string $salt
     */
    private $salt;

    /**
     * @var Flyers\PlanITBundle\Entity\Role
     */
    private $userRoles;

    public function __construct()
    {
        $this->userRoles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get iduser
     *
     * @return integer 
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }
    
	public function equals(UserInterface $user)
    {
        return md5($this->getUsername()) == md5($user->getUsername());
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Add userRoles
     *
     * @param Flyers\PlanITBundle\Entity\Role $userRoles
     */
    public function addRole(\Flyers\PlanITBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;
    }

    /**
     * Get userRoles
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }
    
	/**
     * Gets an array of roles.
     *
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }
    
    public function eraseCredentials()
    {
 
    } 
    /**
     * @var integer $id
     */
    private $id;


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
     * Add userRoles
     *
     * @param Flyers\PlanITBundle\Entity\Role $userRoles
     * @return User
     */
    public function addUserRole(\Flyers\PlanITBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;
    
        return $this;
    }

    /**
     * Remove userRoles
     *
     * @param Flyers\PlanITBundle\Entity\Role $userRoles
     */
    public function removeUserRole(\Flyers\PlanITBundle\Entity\Role $userRoles)
    {
        $this->userRoles->removeElement($userRoles);
    }
    /**
     * @var boolean $active
     */
    private $active;


    /**
     * Set active
     *
     * @param boolean $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
}