<?php

namespace Flyers\PlanITBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('estimate')
            ->add('project', 'entity', array(
                'class' => 'PlanITBundle:Project',
                'property' => 'id'
                ))
            ->add('employees', 'entity', array(
                'class' => 'PlanITBundle:Employee',
                'property' => 'id',
                'multiple' => true
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Flyers\PlanITBundle\Entity\Task',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'task';
    }
}
