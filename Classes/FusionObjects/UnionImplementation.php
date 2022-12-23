<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\DisjunctionValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Fusion\Exception\RuntimeException;
use Neos\Fusion\FusionObjects\AbstractArrayFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\OneOfValidator;

class UnionImplementation extends AbstractArrayFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): ValidatorInterface
    {
        $validators = [];
        foreach ($this->evaluateNestedProperties() as $key => $item) {
            if ($item instanceof ValidatorInterface) {
                $validators[] = $item;
            } else {
                throw new RuntimeException("Union Validator accepts only Validators as children");
            }
        }

        if (count($validators) === 0) {
            throw new RuntimeException("Union Validator needs at least one child");
        } elseif (count($validators) === 1) {
            return array_pop($validators);
        } else {
            $disjunctionValidator = new DisjunctionValidator();
            foreach($validators as $validator) {
                $disjunctionValidator->addValidator($validator);
            }
            return $disjunctionValidator;
        }
    }
}
