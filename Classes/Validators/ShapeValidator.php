<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;

/**
 * Validator for shapes.
 */
class ShapeValidator extends AbstractValidator
{
    /**
     * @var array
     */
    protected $supportedOptions = [
        'shape' => array([], 'The expected shape for this property', 'array')
    ];

    /**
     * Checks if the given value is accepted.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    protected function isValid($value)
    {
        if (is_null($value)){
            return;
        }

        if (is_array($value)){
            foreach($this->options['shape'] as $key => $subValidator) {
                if (array_key_exists($key, $value)) {
                    $subValue = $value[$key];
                    if ($subValidator instanceof ValidatorInterface) {
                        $subResult = $subValidator->validate($subValue);
                        if ($subResult->hasErrors() ) {
                            $this->addError('Key %s is not valid', 1515003533, [$key]);
                        }
                    }
                }
            }
        }
    }
}
