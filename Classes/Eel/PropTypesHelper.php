<?php
namespace PackageFactory\AtomicFusion\PropTypes\Eel;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use PackageFactory\AtomicFusion\PropTypes\Validators\PropTypeValidator;

class PropTypesHelper implements ProtectedContextAwareInterface
{
    /**
     * Create a fresh instance of the PropTypeValidator and call the first method
     *
     * @param $methodName
     * @param $arguments
     * @return PropTypeValidator
     */
    public function __call($methodName, $arguments)
    {
        $validator = new PropTypeValidator();
        if (in_array($methodName, PropTypeValidator::VALID_EEL_METHODS)) {
            return $validator->{$methodName}(...$arguments);
        } else {
            throw new \Exception('This is not supported');
        }
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function allowsCallOfMethod($methodName)
    {
        return in_array($methodName, PropTypeValidator::VALID_EEL_METHODS);
    }
}
