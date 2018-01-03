<?php
namespace PackageFactory\AtomicFusion\PropTypes\Eel;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;

class PropTypesHelper implements ProtectedContextAwareInterface
{
    public function __call($methodName, $arguments) {
        $validatorBuilder = new PropTypesValidator();
        return call_user_func([$validatorBuilder, $methodName], $arguments);
    }

    public function allowsCallOfMethod($methodName)
    {
        return method_exists(PropTypesValidator::class, $methodName);
    }
}
