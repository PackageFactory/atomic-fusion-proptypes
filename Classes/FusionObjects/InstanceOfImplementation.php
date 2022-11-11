<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\StringValidator;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\InstanceOfValidator;

class InstanceOfImplementation extends AbstractFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): InstanceOfValidator
    {
        return new InstanceOfValidator(['type' => $this->fusionValue('type')]);
    }
}
