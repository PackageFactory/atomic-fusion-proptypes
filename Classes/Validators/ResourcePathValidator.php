<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use PackageFactory\AtomicFusion\PropTypes\Eel\PropTypesValidator;

/**
 * Validator for resource-pathes.
 *
 * @api
 */
class ResourcePathValidator extends AbstractValidator
{
    /**
     * Checks if the given value is accepted.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    protected function isValid($value)
    {
        if (is_null($value) || $value === '') {
            return;
        }

        if (is_string($value) === false || file_exists($value) === false) {
            $valueMessage = is_string($value) ? sprintf('"%s"', $value) : 'The given value';
            $this->addError($valueMessage . ' is no valid resource-path', 1515053653);
        }
    }
}
