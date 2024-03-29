<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Validation\Validator\AbstractValidator;
use Neos\Eel\FlowQuery\FlowQuery;

/**
 * Validator for flowQueries.
 */
class InstanceOfValidator extends AbstractValidator
{
    protected $acceptsEmptyValues = false;

    /**
     * @var array
     */
    protected $supportedOptions = [
        'type' => [null, 'The expected type', 'string']
    ];

    /**
     * Checks if the given value is a valid via FlowQuery.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    protected function isValid($value)
    {
        if (is_null($value)) {
            return;
        } elseif ($value) {
            $context = [$value];
        } else {
            $context = [];
        }

        $q = new FlowQuery($context);

        if ($q->is('[instanceof ' . $this->options['type'] . ']')) {
            return;
        }

        $this->addError('The value is expected to satisfy the %s flowQuery condition.', 1515144113, [
            $this->options['type']
        ]);
    }
}
