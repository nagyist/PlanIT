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
 * Flyers\PlanITBundle\Entity\Assignment
 */
class Assignment
{
    /**
     * @var integer $idassignment
     */
    private $idassignment;

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
     * @var Flyers\PlanITBundle\Entity\Assignment
     */
    private $children;
    
    /**
     * @var Flyers\PlanITBundle\Entity\Project
     */
    private $project;
    
    /**
     * @var date $begin
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $begin;
    
    /**
     * @var datetime $end
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $end;

    /**
     * @var Flyers\PlanITBundle\Entity\Person
     */
    private $persons;

    public function __construct()
    {
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get idassignment
     *
     * @return integer 
     */
    public function getIdassignment()
    {
        return $this->idassignment;
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
     * Set project
     *
     * @param Flyers\PlanITBundle\Entity\Project $project
     */
    public function setProject(\Flyers\PlanITBundle\Entity\Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get project
     *
     * @return Flyers\PlanITBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add persons
     *
     * @param Flyers\PlanITBundle\Entity\Person $persons
     */
    public function addPerson(\Flyers\PlanITBundle\Entity\Person $persons)
    {
        $this->persons[] = $persons;
    }

    /**
     * Get persons
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * @var Flyers\PlanITBundle\Entity\Assignment
     */
    private $parent;


    /**
     * Set parent
     *
     * @param Flyers\PlanITBundle\Entity\Assignment $parent
     */
    public function setParent(\Flyers\PlanITBundle\Entity\Assignment $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Flyers\PlanITBundle\Entity\Assignment 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Flyers\PlanITBundle\Entity\Assignment $children
     */
    public function addAssignment(\Flyers\PlanITBundle\Entity\Assignment $children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set begin
     *
     * @param date $begin
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;
    }

    /**
     * Get begin
     *
     * @return date 
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
}