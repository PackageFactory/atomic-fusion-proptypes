<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\ConjunctionValidator;
use Neos\Flow\Validation\Validator\NotEmptyValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;

trait AbstractValidatorTrait
{
    public function evaluate(): ValidatorInterface
    {
        $validator = $this->createValidator();
        if ($this->fusionValue('__meta/required')) {
            if ($validator instanceof ConjunctionValidator) {
                $validator->addValidator(new NotEmptyValidator());
                return $validator;
            } else {
                $conjunctionValidator = new ConjunctionValidator();
                $conjunctionValidator->addValidator($validator);
                $conjunctionValidator->addValidator(new NotEmptyValidator());
                return $conjunctionValidator;
            }
        }
        return $validator;
    }

    abstract function createValidator(): ValidatorInterface;
}
