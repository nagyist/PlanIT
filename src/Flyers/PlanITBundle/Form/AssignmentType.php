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
  
 * Copyright 2012 BEN GHMISS Nassim
 * 
 */

namespace Flyers\PlanITBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Flyers\PlanITBundle\Repository\ProjectRepository;
use Flyers\PlanITBundle\Repository\PersonRepository;
use Flyers\PlanITBundle\Repository\AssignmentRepository;

use Flyers\PlanITBundle\Entity\Assignment;

class AssignmentType extends AbstractType
{
	private $user;
	
	public function __construct($user)
	{
		$this->user = $user;
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$user = $this->user;
        $builder
            ->add('name')
            ->add('description')
			->add('duration')
            /*->add('begin', 'datetime',
            	array(
	    			'input'  => 'datetime',
	    			'widget' => 'single_text',
	            ))
            ->add('end', 'datetime', 
	            array(
	    			'input'  => 'datetime',
	    			'widget' => 'single_text',
	            ))*/
            ->add('parent', 'entity', 
            	array(
            		'empty_value' => 'No preceeding',
            		'empty_data'  => null,
            		'required' => false,
            		'class' => 'PlanITBundle:Assignment',
            		'property' => 'name',
            		'query_builder' => function(AssignmentRepository  $qb) use ($user) {
            			return  $qb	->findAllByUserQuery($user);
            		},
            	))
            ->add('persons', 'entity', 
            	array(
            		'class' => 'PlanITBundle:Person',
            		'property' => 'lastname',
            		'multiple' => true,
            		'expanded' => true,
            		'query_builder' => function(PersonRepository  $qb) use ($user) {
            			return  $qb	->findAllByUserQuery($user);
            		},
            	))
			->add('project', 'entity', 
            	array(
            		'required' => true,
            		'class' => 'PlanITBundle:Project',
            		'property' => 'name',
            		'query_builder' => function(ProjectRepository  $qb) use ($user) {
            			return  $qb	->findAllByUserQuery($user);
            		},
            	));
    }

    public function getName()
    {
        return 'flyers_planitbundle_assignmenttype';
    }
}
