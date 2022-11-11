<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\DisjunctionValidator;
use Neos\Fusion\FusionObjects\AbstractArrayFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\ArrayOfValidator;

class ArrayOfImplementation extends AbstractArrayFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): ArrayOfValidator
    {
        $disjunctionValidator = new DisjunctionValidator();
        foreach ($this->evaluateNestedProperties() as $key => $validator) {
            $disjunctionValidator->addValidator($validator);
        }

        return new ArrayOfValidator(["itemValidator" => $disjunctionValidator]);
    }
}
