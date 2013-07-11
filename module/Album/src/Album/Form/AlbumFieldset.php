<?php
namespace Album\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

use Album\Entity\Album;

class AlbumFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($name = null)
    {
        parent::__construct('album');

        $this   ->setHydrator(new ClassMethodsHydrator(false))
                ->setObject(new Album());

        $this->setLabel('Album');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        $this->add(array(
            'name' => 'artist',
            'attributes' => array(
                'type' => 'text',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Artist',
            ),
        ));
    }

    /**
    * Define InputFilterSpecifications
    *
    * @access public
    * @return array
    */
    public function getInputFilterSpecification()
    {
        return array(
            'title' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'properties' => array(
                    'required' => true
                )
            ),
            'artist' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'properties' => array(
                    'required' => true
                )
            )
        );
    }
}