<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;

/**
 * Validator for integers.
 *
 * @api
 */
class OneOfValidator extends AbstractValidator
{
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
        if (in_array($value, $this->options['values']) === false) {
            $this->addError('One of %s is expected.', 1514999090, [json_encode($this->options['values'])]);
        }
    }
}
