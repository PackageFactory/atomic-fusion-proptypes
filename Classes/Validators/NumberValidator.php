<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\NumberValidator as FlowNumberValidator;

/**
 * Validator for numbers.
 */
class NumberValidator extends FlowNumberValidator
{
    protected $acceptsEmptyValues = false;

    protected function isValid($value)
    {
        if (is_null($value)) {
            return;
        }
        return parent::isValid($value);
    }
}
