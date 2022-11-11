<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\DisjunctionValidator;
use Neos\Fusion\FusionObjects\AbstractArrayFusionObject;

class AnyOfImplementation extends AbstractArrayFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): DisjunctionValidator
    {
        $disjunctionValidator = new DisjunctionValidator();
        foreach ($this->evaluateNestedProperties() as $key => $validator) {
            $disjunctionValidator->addValidator($validator);
        }
        return $disjunctionValidator;
    }
}
