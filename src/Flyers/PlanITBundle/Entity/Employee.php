<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity(repositoryClass="Flyers\PlanITBundle\Entity\EmployeeRepository")
 * @ExclusionPolicy("none") 
 */
class Employee
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
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var float
     *
     * @ORM\Column(name="salary", type="decimal", nullable=true)
     */
    private $salary;

    /**
     * @var Flyers\PlanITBundle\Entity\Job $job
     *
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="employees")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id", nullable=true)
     **/
    private $job;

    /**
     * @var ArrayCollection $tasks
     *
     * @ORM\ManyToMany(targetEntity="Task", mappedBy="employees")
     * @Exclude
     */
    private $tasks;

    /**
     * @var Flyers\PlanITBundle\Entity\User $user
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="employees")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Exclude
     */
    private $user;

    /**
     * @var ArrayCollection $charges
     *
     * @ORM\OneToMany(targetEntity="Charge", mappedBy="employee", cascade={"remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"created" = "ASC"})
     * @Exclude
     */
    private $charges;


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
     * Set lastname
     *
     * @param string $lastname
     * @return Employee
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
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
     * @return Employee
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
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
     * Set email
     *
     * @param string $email
     * @return Employee
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Employee
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
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
     * Set salary
     *
     * @param float $salary
     * @return Employee
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    
        return $this;
    }

    /**
     * Get salary
     *
     * @return float 
     */
    public function getSalary()
    {
        return $this->salary;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set job
     *
     * @param \Flyers\PlanITBundle\Entity\Job $job
     * @return Employee
     */
    public function setJob(\Flyers\PlanITBundle\Entity\Job $job = null)
    {
        $this->job = $job;
    
        return $this;
    }

    /**
     * Get job
     *
     * @return \Flyers\PlanITBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Add tasks
     *
     * @param \Flyers\PlanITBundle\Entity\Task $tasks
     * @return Employee
     */
    public function addTask(\Flyers\PlanITBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;
    
        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Flyers\PlanITBundle\Entity\Task $tasks
     */
    public function removeTask(\Flyers\PlanITBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Set user
     *
     * @param \Flyers\PlanITBundle\Entity\User $user
     * @return Employee
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
     * Add charges
     *
     * @param \Flyers\PlanITBundle\Entity\Charge $charges
     * @return Employee
     */
    public function addCharge(\Flyers\PlanITBundle\Entity\Charge $charges)
    {
        $this->charges[] = $charges;
    
        return $this;
    }

    /**
     * Remove charges
     *
     * @param \Flyers\PlanITBundle\Entity\Charge $charges
     */
    public function removeCharge(\Flyers\PlanITBundle\Entity\Charge $charges)
    {
        $this->charges->removeElement($charges);
    }

    /**
     * Get charges
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCharges()
    {
        return $this->charges;
    }
}