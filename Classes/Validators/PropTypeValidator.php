<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Validation\Validator\ConjunctionValidator;
use Neos\Flow\Validation\Validator\DisjunctionValidator;
use Neos\Flow\Validation\Validator\StringValidator;
use Neos\Flow\Validation\Validator\IntegerValidator;
use Neos\Flow\Validation\Validator\FloatValidator;
use Neos\Flow\Validation\Validator\NumberValidator;
use Neos\Flow\Validation\Validator\RegularExpressionValidator;
use Neos\Flow\Validation\Validator\NotEmptyValidator;

class PropTypeValidator extends ConjunctionValidator implements ProtectedContextAwareInterface
{

    const VALID_EEL_METHODS = [
        'getIsRequired',
        'getString',
        'getBoolean',
        'getInteger',
        'getFloat',
        'getNumber',
        'getResourcePath',
        'regex',
        'arrayOf',
        'shape',
        'anyOf',
        'oneOf'
    ];

    /**
     * @var ConjunctionValidator
     * @Flow\Inject
     */
    protected $conjunctionValidator;

    public function getIsRequired()
    {
        $this->addValidator(new NotEmptyValidator());
        return $this;
    }

    public function getString()
    {
        $this->addValidator(new StringValidator());
        return $this;
    }

    public function getBoolean()
    {
        $this->addValidator(new BooleanValidator());
        return $this;
    }

    public function getInteger()
    {
        $this->addValidator(new IntegerValidator());
        return $this;
    }

    public function getFloat()
    {
        $this->addValidator(new FloatValidator());
        return $this;
    }

    public function getNumber()
    {
        $this->addValidator(new NumberValidator());
        return $this;
    }

    public function getResourcePath()
    {
        $this->addValidator(new ResourcePathValidator());
        return $this;
    }

    public function regex($regularExpression)
    {
        $this->addValidator(new RegularExpressionValidator(['regularExpression' => $regularExpression]));
        return $this;
    }

    public function oneOf($arguments)
    {
        $this->addValidator(new OneOfValidator(['values' => $arguments]));
        return $this;
    }

    public function arrayOf($arguments)
    {
        $this->addValidator(new ArrayOfValidator(['itemValidator' => $arguments[0]]));
        return $this;
    }

    public function anyOf($arguments)
    {
        $disjunctionValidator = new DisjunctionValidator();
        foreach($arguments as $argument) {
            $disjunctionValidator->addValidator($argument);
        }
        $this->addValidator($disjunctionValidator);
        return $this;
    }

    public function shape($arguments)
    {
        $this->addValidator(new ShapeValidator(['shape' => $arguments[0]]));
        return $this;
    }

    public function allowsCallOfMethod($methodName)
    {
        return in_array($methodName, self::VALID_EEL_METHODS) ;
    }

}
