<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TaskRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TaskRepository extends EntityRepository
{
	public function findAll()
  {
		return $this->findBy(array(), array('begin' => 'ASC'));
  }
  
  public function findByProject($project)
  {
	  return $this->findBy(array('project'=>$project), array('begin' => 'ASC'));
  }
}
