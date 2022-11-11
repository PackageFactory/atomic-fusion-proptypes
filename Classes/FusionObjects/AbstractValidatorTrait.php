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
            $conjunctionCalidator = new ConjunctionValidator();
            $conjunctionCalidator->addValidator($validator);
            $conjunctionCalidator->addValidator(new NotEmptyValidator());
            return $conjunctionCalidator;
        }
        return $validator;
    }

    abstract function createValidator(): ValidatorInterface;
}
