<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Utility\ObjectAccess;

/**
 * Validator for shapes.
 */
class ShapeValidator extends AbstractValidator
{
    protected $acceptsEmptyValues = false;

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
        if (is_null($value)) {
            return;
        }

        if (is_array($value) || ($value instanceof \ArrayAccess) || is_object($value)) {
            foreach ($this->options['shape'] as $key => $subValidator) {
                if (is_array($value) || ($value instanceof \ArrayAccess)) {
                    if (array_key_exists($key, $value)) {
                        $subValue = $value[$key];
                    } else {
                        $subValue = null;
                    }
                } elseif (ObjectAccess::isPropertyGettable($value, $key)) {
                    $subValue = ObjectAccess::getPropertyPath($value, $key);
                } else {
                    $subValue = null;
                }

                if ($subValidator instanceof ValidatorInterface) {
                    $subResult = $subValidator->validate($subValue);
                    if ($subResult->hasErrors()) {
                        $this->result->forProperty($key)->merge($subResult);
                    }
                }
            }
        } else {
            $this->addError('Shape-value is expected to be an array or implement ArrayAccess', 1515070099);
        }
    }
}
