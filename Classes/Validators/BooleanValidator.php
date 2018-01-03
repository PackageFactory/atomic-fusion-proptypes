<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;

/**
 * Validator for integers.
 *
 * @api
 * @Flow\Scope("singleton")
 */
class BooleanValidator extends AbstractValidator
{
    /**
     * Checks if the given value is a valid boolean.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    protected function isValid($value)
    {
        if (is_bool($value) === false) {
            $this->addError('A valid boolean is expected.', 1514998717);
        }
    }
}
