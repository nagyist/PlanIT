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
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
                ))
            ->add('end', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
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
        return 'flyers_planitbundle_projecttype';
    }
}
