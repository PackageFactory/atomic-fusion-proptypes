<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;

/**
 * Validator for integers.
 *
 * @api
 */
class ArrayOfValidator extends AbstractValidator
{
    /**
     * @var array
     */
    protected $supportedOptions = [
        'itemValidator' => array(null, 'All items of the array satify this validator', 'Validatop')
    ];

    /**
     * Checks if the given value is accepted.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    protected function isValid($value)
    {
        /**
         * @var ValidatorInterface $itemValidator
         */
        $itemValidator = $this->options['itemValidator'];
        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $itemResult = $itemValidator->validate($item);
                if ($itemResult->hasErrors() ) {
                    $this->addError('Item %s is not valid', 1515003545, [$key]);
                }
            }
        }
    }
}
