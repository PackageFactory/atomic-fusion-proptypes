<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Fusion\FusionObjects\AbstractFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\DataStructureValidator;

class ForPrototypeImplementation extends AbstractFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): DataStructureValidator
    {
        $prototypeName = $this->fusionValue('prototypeName');
        return $this->getRuntime()->evaluate('/<' . $prototypeName . '>/__meta/propTypes<PackageFactory.AtomicFusion.PropTypes:DataStructure>');
    }
}
