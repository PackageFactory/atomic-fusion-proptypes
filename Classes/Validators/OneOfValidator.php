<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;

/**
 * Disjunction-validator for multiple types
 */
class OneOfValidator extends AbstractValidator
{
    protected $acceptsEmptyValues = false;

    /**
     * @var array
     */
    protected $supportedOptions = [
        'values' => array([], 'Array of values that are considered valid', 'array')
    ];

    /**
     * Checks if the given value is accepted.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    protected function isValid($value)
    {
        if (is_null($value)) {
            return;
        }

        if (in_array($value, $this->options['values'], true)) {
            return;
        }

        $errorMessage = 'One of %s is expected.';

        if (is_string($value)) {
            $errorMessage .= sprintf(' Got "%s" instead.', $value);
        }

        $this->addError($errorMessage, 1514999090, [json_encode($this->options['values'])]);
    }
}
