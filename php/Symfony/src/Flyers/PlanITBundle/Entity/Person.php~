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
 * Flyers\PlanITBundle\Entity\Person
 */
class Person
{
    /**
     * @var integer $idperson
     */
    private $idperson;

    /**
     * @var string $lastname
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string $firstname
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string $mail
     * @Assert\Email(
     *    message = "The mail address is not valid",
     *    checkMX = true
     * )
     */
    private $mail;

    /**
     * @var string $phone
     */
    private $phone;

    /**
     * @var Flyers\PlanITBundle\Entity\Job
     */
    private $job;


    /**
     * Get idperson
     *
     * @return integer 
     */
    public function getIdperson()
    {
        return $this->idperson;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set mail
     *
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set phone
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set job
     *
     * @param Flyers\PlanITBundle\Entity\Job $job
     */
    public function setJob(\Flyers\PlanITBundle\Entity\Job $job)
    {
        $this->job = $job;
    }

    /**
     * Get job
     *
     * @return Flyers\PlanITBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @var Flyers\PlanITBundle\Entity\Project
     */
    private $projects;

    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add projects
     *
     * @param Flyers\PlanITBundle\Entity\Project $projects
     */
    public function addProject(\Flyers\PlanITBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;
    }

    /**
     * Get projects
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }
    /**
     * @var decimal $salary
     */
    private $salary;


    /**
     * Set salary
     *
     * @param decimal $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * Get salary
     *
     * @return decimal 
     */
    public function getSalary()
    {
        return $this->salary;
    }
}