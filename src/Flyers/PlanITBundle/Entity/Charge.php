<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * Charge
 *
 * @ORM\Table(name="charge")
 * @ORM\Entity(repositoryClass="Flyers\PlanITBundle\Entity\ChargeRepository")
 * @ExclusionPolicy("none") 
 */
class Charge
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="duration", type="decimal")
     * @Constraints\NotBlank()
     */
    private $duration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date")
     * @Constraints\NotBlank()
     * @Constraints\Type("\DateTime")
     */
    private $created;

    /**
     * @var Flyers\PlanITBundle\Entity\Employee $employee
     *
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="charges", cascade={"persist"})
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     **/
    private $employee;

    /**
     * @var Flyers\PlanITBundle\Entity\Task $task
     *
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="charges", cascade={"persist"})
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     **/
    private $task;

    /**
     * Convert specified duration time to minutes
     *
     * @return float
     */
    public function convertDuration($duration, $base = 0)
    {
        // $floor = floor($duration);
        // $decimal = $duration - $floor;

        // hours
        if ($base == 1)
        {
            return $duration * 60;
        }
        // day
        else if ($base == 2)
        {
            return $duration * 60 * 24; 
        }
        // month
        else if ($base == 3)
        {
            return $duration * 60 * 24 * date('t');
        }
        return $duration;
    }

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
     * Set description
     *
     * @param string $description
     * @return Charge
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user
     *
     * @param \Flyers\PlanITBundle\Entity\User $user
     * @return Charge
     */
    public function setUser(\Flyers\PlanITBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Flyers\PlanITBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set employee
     *
     * @param \Flyers\PlanITBundle\Entity\Employee $employee
     * @return Charge
     */
    public function setEmployee(\Flyers\PlanITBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;
    
        return $this;
    }

    /**
     * Get employee
     *
     * @return \Flyers\PlanITBundle\Entity\Employee 
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set task
     *
     * @param \Flyers\PlanITBundle\Entity\Task $task
     * @return Charge
     */
    public function setTask(\Flyers\PlanITBundle\Entity\Task $task = null)
    {
        $this->task = $task;
    
        return $this;
    }

    /**
     * Get task
     *
     * @return \Flyers\PlanITBundle\Entity\Task 
     */
    public function getTask()
    {
        return $this->task;
    }

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
     * Set created
     *
     * @param \DateTime $created
     * @return Charge
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}