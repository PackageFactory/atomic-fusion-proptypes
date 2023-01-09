<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\IntegerValidator;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\BooleanValidator;

class BoolImplementation extends AbstractFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): BooleanValidator
    {
        return new BooleanValidator();
    }
}
