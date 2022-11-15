<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\DisjunctionValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Fusion\Exception\RuntimeException;
use Neos\Fusion\FusionObjects\AbstractArrayFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\OneOfValidator;

class AnyOfImplementation extends AbstractArrayFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): ValidatorInterface
    {
        $validators = [];
        $values = [];
        foreach ($this->evaluateNestedProperties() as $key => $item) {
            if ($item instanceof ValidatorInterface) {
                $validators[] = $item;
            } else {
                $values[] = $item;
            }
        }

        if (count($values) > 0) {
            $validators[] = new OneOfValidator(['values' => $values]);
        }

        if (count($validators) === 0) {
            throw new RuntimeException("AnyOf Validator needs at least one children");
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
