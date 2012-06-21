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

namespace Flyers\PlanITBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Flyers\PlanIT\Entity\Person;
use Flyers\PlanIT\Entity\Team;

/**
 * PersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonRepository extends EntityRepository
{
	
	public function findAllByUser($user) 
	{
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb	->select("p")
			->from("PlanITBundle:Person", "p")
			->join("p.projects", "a")
			->where("a.user = :id" )
			->setParameter( "id", $user->getId() );
		return $qb;
	}
	

}