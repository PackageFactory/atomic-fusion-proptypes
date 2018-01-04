<?php
namespace PackageFactory\AtomicFusion\PropTypes\Eel;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use PackageFactory\AtomicFusion\PropTypes\Validators\PropTypeValidator;

class PropTypesHelper implements ProtectedContextAwareInterface
{
    public function __call($methodName, $arguments)
    {
        $validator = new PropTypeValidator();
        return call_user_func([$validator, $methodName], $arguments);
    }

    public function allowsCallOfMethod($methodName)
    {
        return in_array($methodName, PropTypeValidator::VALID_EEL_METHODS) ;
    }
}
