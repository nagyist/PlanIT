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
  
 * « Copyright 2012 BEN GHMISS Nassim »  
 * 
 */

namespace Flyers\PlanITBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Flyers\PlanITBundle\Repository\ProjectRepository;

class PersonType extends AbstractType
{
private $user;
	
	public function __construct($user)
	{
		$this->user = $user;
	}
	
    public function buildForm(FormBuilder $builder, array $options)
    {
    	$user = $this->user;
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('mail')
            ->add('phone')
            ->add('salary')
            ->add('job', 'entity', 
            	array(
            		'class' => 'PlanITBundle:Job',
            		'property' => 'name'
            	))
            ->add('projects', 'entity', 
            	array(
            		'class' => 'PlanITBundle:Project',
            		'property' => 'name',
            		'multiple' => true,
            		'expanded' => false,
            		'query_builder' => function(ProjectRepository  $qb) use ($user) {
            			return  $qb	->findAllByUser($user);
            		},
            	))
        ;
    }

    public function getName()
    {
        return 'flyers_planitbundle_persontype';
    }
}
