<?php
namespace PackageFactory\AtomicFusion\PropTypes\Validators;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Validation\Validator\ConjunctionValidator;
use Neos\Flow\Validation\Validator\DisjunctionValidator;
use Neos\Flow\Validation\Validator\StringValidator;
use Neos\Flow\Validation\Validator\RegularExpressionValidator;
use Neos\Flow\Validation\Validator\NotEmptyValidator;
use Neos\Flow\Validation\Validator\ValidatorInterface;

class PropTypeValidator extends ConjunctionValidator implements ProtectedContextAwareInterface
{

    /**
     * @return $this
     */
    public function getAny()
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function getIsRequired()
    {
        $this->addValidator(new NotEmptyValidator());
        return $this;
    }

    /**
     * @return $this
     */
    public function getString()
    {
        $this->addValidator(new StringValidator());
        return $this;
    }

    /**
     * @return $this
     */
    public function getBoolean()
    {
        $this->addValidator(new BooleanValidator());
        return $this;
    }

    /**
     * @return $this
     */
    public function getInteger()
    {
        $this->addValidator(new IntegerValidator());
        return $this;
    }

    /**
     * @return $this
     */
    public function getFloat()
    {
        $this->addValidator(new FloatValidator());
        return $this;
    }

    /**
     * @return $this
     */
    public function getFileExists()
    {
        $this->addValidator(new FileExistsValidator());
        return $this;
    }

    /**
     * @param string $regularExpression
     * @return $this
     */
    public function regex($regularExpression)
    {
        $this->addValidator(new RegularExpressionValidator(['regularExpression' => $regularExpression]));
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function oneOf(array $values)
    {
        $this->addValidator(new OneOfValidator(['values' => $values]));
        return $this;
    }

    /**
     * @param ValidatorInterface $values
     * @return $this
     */
    public function arrayOf(ValidatorInterface $itemValidator)
    {
        $this->addValidator(new ArrayOfValidator(['itemValidator' => $itemValidator]));
        return $this;
    }

    /**
     * @param ValidatorInterface[] ...$validators
     * @return $this
     */
    public function anyOf(ValidatorInterface ...$validators)
    {
        $disjunctionValidator = new DisjunctionValidator();
        foreach ($validators as $validator) {
            $disjunctionValidator->addValidator($validator);
        }
        $this->addValidator($disjunctionValidator);
        return $this;
    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function shape($shape)
    {
        $this->addValidator(new DataStructureValidator(['dataStructure' => $shape]));
        return $this;
    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function dataStructure($shape)
    {
        $this->addValidator(new DataStructureValidator(['dataStructure' => $shape]));
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function instanceOf($type)
    {
        $this->addValidator(new InstanceOfValidator(['type' => $type]));
        return $this;
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function allowsCallOfMethod($methodName)
    {
        return $methodName == 'getIsRequired';
    }
}
