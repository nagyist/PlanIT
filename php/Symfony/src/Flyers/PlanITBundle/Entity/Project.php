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
  
 * � Copyright 2012 BEN GHMISS Nassim �  
 * 
 */

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Flyers\PlanITBundle\Entity\Project
 */
class Project
{
    /**
     * @var integer $idproject
     */
    private $idproject;

    /**
     * @var string $name
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var text $description
     */
    private $description;

    /**
     * @var datetime $begin
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $begin;

    /**
     * @var datetime $end
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $end;


    /**
     * Get idproject
     *
     * @return integer 
     */
    public function getIdproject()
    {
        return $this->idproject;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set begin
     *
     * @param datetime $begin
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;
    }

    /**
     * Get begin
     *
     * @return datetime 
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set end
     *
     * @param datetime $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * Get end
     *
     * @return datetime 
     */
    public function getEnd()
    {
        return $this->end;
    }
    /**
     * @var Flyers\PlanITBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param Flyers\PlanITBundle\Entity\User $user
     */
    public function setUser(\Flyers\PlanITBundle\Entity\User $user)
    {
        $this->user = $user;
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