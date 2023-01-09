<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Fusion\FusionObjects\AbstractArrayFusionObject;
use PackageFactory\AtomicFusion\PropTypes\Validators\DataStructureValidator;

class DataStructureImplementation extends AbstractArrayFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): DataStructureValidator
    {
        $resultParts = [];
        foreach ($this->evaluateNestedProperties() as $key => $item) {
            $resultParts[$key] = $item;
        }
        return new DataStructureValidator(['dataStructure' => $resultParts]);
    }
}
