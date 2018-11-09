<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Utility\ObjectAccess;

/**
 * Validator for data-structures.
 */
class DataStructureValidator extends AbstractValidator
{
    protected $acceptsEmptyValues = false;

    /**
     * @var array
     */
    protected $supportedOptions = [
        'dataStructure' => array([], 'The expected data-structure for this property', 'array')
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
            foreach ($this->options['dataStructure'] as $key => $subValidator) {
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
                        $this->addError('DataStructure-Property %s is not valid', 1515003533, [$key]);
                    }
                }
            }
        } else {
            $this->addError('DataStructure is expected to be an array or implement ArrayAccess', 1515070099);
        }
    }
}
