<?php
namespace PackageFactory\AtomicFusion\PropTypes\Aspects;

use Neos\Error\Messages\Error;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;
use PackageFactory\AtomicFusion\PropTypes\Error\Exception\PropTypeException;
use Neos\Error\Messages\Result;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use Neos\Utility\ObjectAccess;

/**
 * @Flow\Scope("singleton")
 * @Flow\Aspect
 */
class PropTypeValidationAspect
{
    /**
     * @Flow\Around("setting(PackageFactory.AtomicFusion.PropTypes.enable) && method(Neos\Fusion\FusionObjects\ComponentImplementation->getProps())")
     * @param JoinPointInterface $joinPoint The current join point
     * @return mixed
     */
    public function validatePropTypesForFusionComponents(JoinPointInterface $joinPoint)
    {
        return $this->validateFusionPropTypes($joinPoint);
    }

    /**
     * @Flow\Around("setting(PackageFactory.AtomicFusion.PropTypes.enable) && method(PackageFactory\AtomicFusion\FusionObjects\ComponentImplementation->getProps())")
     * @param JoinPointInterface $joinPoint The current join point
     * @return mixed
     */
    public function validatePropTypesForPackageFactoryAtomicFusionComponents(JoinPointInterface $joinPoint)
    {
        return $this->validateFusionPropTypes($joinPoint);
    }

    /**
     * @param JoinPointInterface $joinPoint
     * @return mixed
     */
    protected function validateFusionPropTypes(JoinPointInterface $joinPoint)
    {
        $fusionComponentImplementation = $joinPoint->getProxy();
        $strictMode = $fusionComponentImplementation['__meta/propTypes/__meta/strict'];
        $validators = $fusionComponentImplementation['__meta/propTypes<Neos.Fusion:RawArray>'];
        $props = $joinPoint->getAdviceChain()->proceed($joinPoint);

        $validationResult = new Result();
        $validatedPropNames = [];

        // lazy prop validation
        foreach ($validators as $propName => $validator) {
            $propValue = $props[$propName] ?? null;
            if ($validator instanceof ValidatorInterface) {
                $validationResult->forProperty($propName)->merge($validator->validate($propValue));
            } else {
                $validationResult->forProperty($propName)->addError(
                    new Error(
                        sprintf(
                            'propType for prop %s must implement the ValidatorInterface %s found instead',
                            $propName, (is_object($validator) ? get_class($validator) : gettype($validator))
                        )
                    )
                );
            }
            $validatedPropNames[] = $propName;
        }

        // strict prop validation
        if ($strictMode === true) {
            foreach ($props as $propName => $propValue) {
                if (!in_array($propName, $validatedPropNames)) {
                    $validationResult->forProperty($propName)->addError(
                        new Error(
                            sprintf(
                                'propType for prop %s is not declared but %s is passed',
                                $propName,
                                gettype($propValue)
                            )
                        )
                    );
                }
            }
        }

        if ($validationResult->hasErrors()) {
            $prototypeName = ObjectAccess::getProperty($fusionComponentImplementation, 'fusionObjectName', true);
            $exception = new PropTypeException(sprintf('The PropType validation for prototype %s failed', $prototypeName));
            $exception->setResult($validationResult);
            throw $exception;
        }

        return $props;
    }

}
