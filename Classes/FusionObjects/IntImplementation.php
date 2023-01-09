<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\IntegerValidator;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class IntImplementation extends AbstractFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): IntegerValidator
    {
        return new IntegerValidator();
    }
}
