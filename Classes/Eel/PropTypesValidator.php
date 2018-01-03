<?php
namespace PackageFactory\AtomicFusion\PropTypes\Eel;

use Neos\Error\Messages\Result as ErrorResult;
use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Flow\Validation\Validator\ConjunctionValidator;
use Neos\Flow\Validation\Validator\DisjunctionValidator;
use Neos\Flow\Validation\Validator\StringValidator;
use Neos\Flow\Validation\Validator\IntegerValidator;
use Neos\Flow\Validation\Validator\FloatValidator;
use Neos\Flow\Validation\Validator\NumberValidator;
use Neos\Flow\Validation\Validator\RegularExpressionValidator;
use Neos\Flow\Validation\Validator\NotEmptyValidator;

use PackageFactory\AtomicFusion\PropTypes\Validators\BooleanValidator;
use PackageFactory\AtomicFusion\PropTypes\Validators\OneOfValidator;
use PackageFactory\AtomicFusion\PropTypes\Validators\ArrayOfValidator;
use PackageFactory\AtomicFusion\PropTypes\Validators\ShapeValidator;

class PropTypesValidator implements ProtectedContextAwareInterface, ValidatorInterface
{
    /**
     * @var ConjunctionValidator
     * @Flow\Inject
     */
    protected $conjunctionValidator;

    public function getIsRequired()
    {
        $this->conjunctionValidator->addValidator(new NotEmptyValidator());
        return $this;
    }

    public function getString()
    {
        $this->conjunctionValidator->addValidator(new StringValidator());
        return $this;
    }

    public function getBoolean()
    {
        $this->conjunctionValidator->addValidator(new BooleanValidator());
        return $this;
    }

    public function getInteger()
    {
        $this->conjunctionValidator->addValidator(new IntegerValidator());
        return $this;
    }

    public function getFloat()
    {
        $this->conjunctionValidator->addValidator(new FloatValidator());
        return $this;
    }

    public function getNumber()
    {
        $this->conjunctionValidator->addValidator(new NumberValidator());
        return $this;
    }

    public function regex($regularExpression)
    {
        $this->conjunctionValidator->addValidator(new RegularExpressionValidator(['regularExpression' => $regularExpression]));
        return $this;
    }

    public function oneOf($arguments)
    {
        $this->conjunctionValidator->addValidator(new OneOfValidator(['values' => $arguments]));
        return $this;
    }

    public function arrayOf($arguments)
    {
        $this->conjunctionValidator->addValidator(new ArrayOfValidator(['itemValidator' => $arguments[0]]));
        return $this;
    }

    public function anyOf($arguments)
    {
        $disjunctionValidator = new DisjunctionValidator();
        foreach($arguments as $argument) {
            $disjunctionValidator->addValidator($argument);
        }
        $this->conjunctionValidator->addValidator($disjunctionValidator);
        return $this;
    }

    public function shape($arguments)
    {
        $this->conjunctionValidator->addValidator(new ShapeValidator(['shape' => $arguments[0]]));
        return $this;
    }

    public function validate($value)
    {
        return  $this->conjunctionValidator->validate($value);
    }

    public function getOptions()
    {
        return [];
    }

    public function allowsCallOfMethod($methodName)
    {
        return method_exists($this, $methodName);
    }

}
