<?php

namespace Flyers\PlanITBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('begin', 'date', array(
                'format' => 'dd/MM/yyyy',
                'input' => 'array'
                ))
            ->add('end', 'date', array(
                'format' => 'dd/MM/yyyy',
                'input' => 'array'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Flyers\PlanITBundle\Entity\Project',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'project';
    }
}
