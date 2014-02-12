<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="Flyers\PlanITBundle\Entity\TaskRepository")
 * @ExclusionPolicy("none") 
 */
class Task
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin", type="date")
     */
    private $begin;

    /**
     * @var float
     *
     * @ORM\Column(name="estimate", type="decimal")
     */
    private $estimate;

    /**
     * @var Flyers\PlanITBundle\Entity\Project $project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks", cascade={"persist"})
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     **/
    private $project;

    /**
     * @var ArrayCollection $employees
     *
     * @ORM\ManyToMany(targetEntity="Employee")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")}
     * )
     */
    private $employees;

    /**
     * @var ArrayCollection $charges
     *
     * @ORM\OneToMany(targetEntity="Charge", mappedBy="task", cascade={"remove"}, orphanRemoval=true)
     * @Exclude
     */
    private $charges;

    /**
     * @var ArrayCollection $children
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="parent", cascade={"remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"begin" = "ASC"})
     * @Exclude
     */
    private $children;

    /**
     * @var Flyers\PlanITBundle\Entity\Task $parent
     *
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $parent;


    /**
     * Convert specified estimate time to minutes
     *
     * @return float
     */
    public function convertEstimate($estimate, $base = 0)
    {
        // $floor = floor($estimate);
        // $decimal = $estimate - $floor;

        // hours
        if ($base == 1)
        {
            return $estimate * 60;
        }
        // day
        else if ($base == 2)
        {
            return $estimate * 60 * 24; 
        }
        // month
        else if ($base == 3)
        {
            return $estimate * 60 * 24 * date('t');
        }
        return $estimate;
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
     * Set name
     *
     * @param string $name
     * @return Task
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

    /**
     * Set description
     *
     * @param string $description
     * @return Task
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
     * Constructor
     */
    public function __construct()
    {
        $this->employees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->charges = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set project
     *
     * @param \Flyers\PlanITBundle\Entity\Project $project
     * @return Task
     */
    public function setProject(\Flyers\PlanITBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \Flyers\PlanITBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add employees
     *
     * @param \Flyers\PlanITBundle\Entity\Employee $employees
     * @return Task
     */
    public function addEmployee(\Flyers\PlanITBundle\Entity\Employee $employees)
    {
        $this->employees[] = $employees;
    
        return $this;
    }

    /**
     * Remove employees
     *
     * @param \Flyers\PlanITBundle\Entity\Employee $employees
     */
    public function removeEmployee(\Flyers\PlanITBundle\Entity\Employee $employees)
    {
        $this->employees->removeElement($employees);
    }

    /**
     * Get employees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * Set estimate
     *
     * @param float $estimate
     * @return Task
     */
    public function setEstimate($estimate)
    {
        $this->estimate = $estimate;
    
        return $this;
    }

    /**
     * Get estimate
     *
     * @return float 
     */
    public function getEstimate()
    {
        return $this->estimate;
    }

    /**
     * Add charges
     *
     * @param \Flyers\PlanITBundle\Entity\Charge $charges
     * @return Task
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

    /**
     * Add children
     *
     * @param \Flyers\PlanITBundle\Entity\Task $children
     * @return Task
     */
    public function addChildren(\Flyers\PlanITBundle\Entity\Task $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Flyers\PlanITBundle\Entity\Task $children
     */
    public function removeChildren(\Flyers\PlanITBundle\Entity\Task $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Flyers\PlanITBundle\Entity\Task $parent
     * @return Task
     */
    public function setParent(\Flyers\PlanITBundle\Entity\Task $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Flyers\PlanITBundle\Entity\Task 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set begin
     *
     * @param \DateTime $begin
     * @return Task
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;
    
        return $this;
    }

    /**
     * Get begin
     *
     * @return \DateTime 
     */
    public function getBegin()
    {
        return $this->begin;
    }
}