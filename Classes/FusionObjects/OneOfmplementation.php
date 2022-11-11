<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\IntegerValidator;
use Neos\Fusion\FusionObjects\AbstractArrayFusionObject;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\OneOfValidator;

class OneOfmplementation extends AbstractArrayFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): OneOfValidator
    {
        return new OneOfValidator(["values" => $this->evaluateNestedProperties()]);
    }
}
