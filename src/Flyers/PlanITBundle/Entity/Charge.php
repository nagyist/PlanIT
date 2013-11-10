<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Charge
 *
 * @ORM\Table(name="charge")
 * @ORM\Entity(repositoryClass="Flyers\PlanITBundle\Entity\ChargeRepository")
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var Flyers\PlanITBundle\Entity\User $user
     *
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @var Flyers\PlanITBundle\Entity\Employee $employee
     *
     * @ORM\OneToOne(targetEntity="Employee")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     **/
    private $employee;

    /**
     * @var Flyers\PlanITBundle\Entity\Task $task
     *
     * @ORM\OneToOne(targetEntity="Task")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     **/
    private $task;


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
}