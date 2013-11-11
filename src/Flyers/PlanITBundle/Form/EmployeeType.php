<?php

namespace Flyers\PlanITBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('phone')
            ->add('salary')
            ->add('job')
            ->add('tasks')
            ->add('projects')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Flyers\PlanITBundle\Entity\Employee'
        ));
    }

    public function getName()
    {
        return 'flyers_planitbundle_employeetype';
    }
}
