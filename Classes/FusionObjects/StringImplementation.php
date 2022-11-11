<?php
declare(strict_types=1);

namespace PackageFactory\AtomicFusion\PropTypes\FusionObjects;

use Neos\Flow\Validation\Validator\ConjunctionValidator;
use Neos\Flow\Validation\Validator\RegularExpressionValidator;
use Neos\Flow\Validation\Validator\StringValidator;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class StringImplementation extends AbstractFusionObject
{
    use AbstractValidatorTrait;

    public function createValidator(): StringValidator
    {
        if ($regularExpression = $this->fusionValue('regularExpression')) {
            $conjunctionCalidator = new ConjunctionValidator();
            $conjunctionCalidator->addValidator(new RegularExpressionValidator(['regularExpression' => $regularExpression]));
            $conjunctionCalidator->addValidator(new StringValidator());
            return $conjunctionCalidator;
        }
        return new StringValidator();
    }
}
