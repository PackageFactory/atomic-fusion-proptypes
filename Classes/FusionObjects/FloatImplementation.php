<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\IntegerValidator;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\FloatValidator;

class FloatImplementation extends AbstractFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): FloatValidator
    {
        return new FloatValidator();
    }
}
