<?php

namespace FDevs\MenuBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParentType extends AbstractType
{
    /** @var string */
    private $parent = 'document';

    /**
     * init
     *
     * @param string $parent
     */
    public function __construct($parent = 'document')
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_menu_parent';
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class'    => 'FDevs\MenuBundle\Model\Menu',
            'required' => false,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return $this->parent;
    }
}
