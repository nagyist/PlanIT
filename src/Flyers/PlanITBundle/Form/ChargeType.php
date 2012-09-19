<?php

namespace Flyers\PlanITBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Flyers\PlanITBundle\Repository\PersonRepository;
use Flyers\PlanITBundle\Repository\AssignmentRepository;

class ChargeType extends AbstractType
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
            ->add('description')
			->add('duration')
            ->add('date', 'datetime',
				array(
	    			'input'  => 'datetime',
	    			'widget' => 'single_text',
	            ))
			/*
            ->add('end', 'datetime',
				array(
	    			'input'  => 'datetime',
	    			'widget' => 'single_text',
	            ))
			 */
            ->add('assignment', 'entity', 
            	array(
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
        ;
    }

    public function getName()
    {
        return 'flyers_planitbundle_chargetype';
    }
}
