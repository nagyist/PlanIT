<?php

namespace Flyers\PlanITBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
	public function findAllByUser($user)
	{
		# TODO edit SQL request
		return $this->getEntityManager()
					->createQuery(
						"SELECT p FROM PlanITBundle:Project p ORDER BY p.begin DESC"
						)
					->getResult();
	}
}
