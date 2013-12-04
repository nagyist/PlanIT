<?php

namespace Flyers\PlanITBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('duration')
            ->add('created', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
                ))
            ->add('employee', 'entity', array(
                'class' => 'PlanITBundle:Employee',
                'property' => 'id'
                ))
            ->add('task', 'entity', array(
                'class' => 'PlanITBundle:Task',
                'property' => 'id'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Flyers\PlanITBundle\Entity\Charge',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'flyers_planitbundle_chargetype';
    }
}
