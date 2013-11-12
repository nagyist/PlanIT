<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="Flyers\PlanITBundle\Entity\ProjectRepository")
 */
class Project
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
     * @Constraints\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @Constraints\Type("\Date")
     *
     * @ORM\Column(name="begin", type="date")
     */
    private $begin;

    /**
     * @var \DateTime
     *
     * @Constraints\Type("\Date")
     *
     * @ORM\Column(name="end", type="date")
     */
    private $end;

    /**
     * @var ArrayCollection $users
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $users;

    /**
     * @var ArrayCollection $employees
     *
     * @ORM\ManyToMany(targetEntity="Employee")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")}
     * )
     */
    private $employees;


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
     * @return Project
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
     * @return Project
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
     * Set begin
     *
     * @param \DateTime $begin
     * @return Project
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

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Project
     */
    public function setEnd($end)
    {
        $this->end = $end;
    
        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add users
     *
     * @param \Flyers\PlanITBundle\Entity\User $users
     * @return Project
     */
    public function addUser(\Flyers\PlanITBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Flyers\PlanITBundle\Entity\User $users
     */
    public function removeUser(\Flyers\PlanITBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add employees
     *
     * @param \Flyers\PlanITBundle\Entity\Employee $employees
     * @return Project
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
}