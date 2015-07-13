<?php

namespace FDevs\MenuBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class ContainsParent extends Constraint
{
    /** @var string */
    public $message = 'Please choice another field';

    /** @var string */
    public $field = 'id';

    /**
     * {@inheritdoc}
     */
    public function getRequiredOptions()
    {
        return array('field');
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'field';
    }
}
