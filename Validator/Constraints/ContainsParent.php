<?php

namespace FDevs\MenuBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class ContainsParent extends Constraint
{
    public $message = 'Pleas choice another field';
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
