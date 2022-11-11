<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;

/**
 * Validator for strings.
 */
class StringValidator extends AbstractValidator
{
    protected $acceptsEmptyValues = false;

    /**
     * Checks if the given value is a string or an object that implements __toString.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    protected function isValid($value)
    {
        if (is_null($value) || is_string($value) || (is_object($value) && method_exists($value, '__toString'))) {
            return;
        }
        $this->addError('A string or an object implementing __toString is expected.', 1617809129);
    }
}
