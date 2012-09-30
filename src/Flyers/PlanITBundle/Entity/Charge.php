<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\ExecutionContext;

/**
 * Flyers\PlanITBundle\Entity\Charge
 * @Assert\Callback(methods={"isChargeValid"})
 */
class Charge
{
    /**
     * @var integer $idcharge
     */
    private $idcharge;

    /**
     * @var text $description
     */
    private $description;

    /**
     * @var Flyers\PlanITBundle\Entity\Assignment
     */
    private $assignment;

    /**
     * @var Flyers\PlanITBundle\Entity\Person
     */
    private $persons;

    public function __construct()
    {
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get idcharge
     *
     * @return integer 
     */
    public function getIdcharge()
    {
        return $this->idcharge;
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
     * Set assignment
     *
     * @param Flyers\PlanITBundle\Entity\Assignment $assignment
     */
    public function setAssignment(\Flyers\PlanITBundle\Entity\Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    /**
     * Get assignment
     *
     * @return Flyers\PlanITBundle\Entity\Assignment 
     */
    public function getAssignment()
    {
        return $this->assignment;
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
	
	public function isChargeValid(ExecutionContext $context) 
	{
		
		if ( is_null($this->getAssignment()) )
		{
            $context->addViolationAtSubPath('assignment', 'You must choose a task', array(), null);
		}
		
		if ( count($this->getPersons()) <= 0)
		{
            $context->addViolationAtSubPath('persons', 'You must assign the charge to someone', array(), null);
		}
	}
    /**
     * @var float $duration
	 * @Assert\NotBlank()
     */
    private $duration;


    /**
     * Set duration
     *
     * @param float $duration
     * @return Charge
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return float 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Remove persons
     *
     * @param Flyers\PlanITBundle\Entity\Person $persons
     */
    public function removePerson(\Flyers\PlanITBundle\Entity\Person $persons)
    {
        $this->persons->removeElement($persons);
    }
    /**
     * @var \DateTime $date
     */
    private $date;


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Charge
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}