<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\DisjunctionValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Fusion\Exception\RuntimeException;
use Neos\Fusion\FusionObjects\AbstractArrayFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\OneOfValidator;

class EnumImplementation extends AbstractArrayFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): ValidatorInterface
    {
        $values = [];
        foreach ($this->evaluateNestedProperties() as $key => $item) {
            $values[] = $item;
        }

        return new OneOfValidator(['values' => $values]);
    }
}
