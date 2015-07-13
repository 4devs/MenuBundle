<?php

namespace FDevs\MenuBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsParentValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var \FDevs\MenuBundle\Model\Menu $object */
        $object = $this->context->getObject();
        $method = 'get'.ucfirst($constraint->field);
        if ($value && $object->{$method}() == $value->{$method}()) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
