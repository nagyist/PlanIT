<?php

namespace Flyers\PlanITBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Flyers\PlanITBundle\Entity\UserRepository")
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    protected $id;
    
    /**
     * @var string email
     *
     * @Constraints\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     *
     */
    protected $email;

    /**
     * @var ArrayCollection $projects
     *
     * @ORM\ManyToMany(targetEntity="Project")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")}
     * )
     */
    private $projects;

    /**
     * @var ArrayCollection $employees
     *
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="user")
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
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();

        parent::__construct();
    }
    
    /**
     * Add projects
     *
     * @param \Flyers\PlanITBundle\Entity\Project $projects
     * @return User
     */
    public function addProject(\Flyers\PlanITBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Flyers\PlanITBundle\Entity\Project $projects
     */
    public function removeProject(\Flyers\PlanITBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add employees
     *
     * @param \Flyers\PlanITBundle\Entity\Employee $employees
     * @return User
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