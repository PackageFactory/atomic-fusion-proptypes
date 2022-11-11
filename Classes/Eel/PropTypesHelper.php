<?php
namespace PackageFactory\AtomicFusion\PropTypes\Eel;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Validation\Validator\ValidatorInterface;
use PackageFactory\AtomicFusion\PropTypes\Validators\PropTypeValidator;

/**
 * Factory for the `@propType` validators of your Fusion components.
 *
 * ```
 * prototype(Vendor.Site:Example) < prototype(Neos.Fusion:Component) {
 *   \@propTypes {
 *     # optional, enforce that only validated props exist
 *     \@strict = true
 *     # validation rules for props
 *     title = ${PropTypes.string.isRequired}
 *     subtitle = ${PropTypes.string}
 *     color = ${PropTypes.oneOf(["red", "marcherry"])}
 *   }
 * }
 * ```
 *
 * Each method will create a new validator.
 * To make a value mandatory you can use the `isRequired` property of the validator.
 *
 * @example PropTypes.oneOf([123, "foo"]).isRequired
 *
 * Note on properties like `isRequired`, `boolean` or `string`
 * Those are not actual properties but implemented as getters like `getString`.
 * Eel will make sure to call the appropriate getter.
 */
class PropTypesHelper implements ProtectedContextAwareInterface
{
    /**
     * Accepts any value including null.
     *
     * @example PropTypes.any
     */
    public function getAny(): PropTypeValidator
    {
        return (new PropTypeValidator())->getAny();
    }

    /**
     * Validate that a boolean value is given, accepts null.
     *
     * @example PropTypes.boolean
     */
    public function getBoolean(): PropTypeValidator
    {
        return (new PropTypeValidator())->getBoolean();
    }

    /**
     * Validate that an integer is given, accepts null.
     *
     * @example PropTypes.integer
     */
    public function getInteger(): PropTypeValidator
    {
        return (new PropTypeValidator())->getInteger();
    }

    /**
     * Validate that an float is given, accepts null.
     *
     * @example PropTypes.float
     */
    public function getFloat(): PropTypeValidator
    {
        return (new PropTypeValidator())->getFloat();
    }

    /**
     * Validate that an string is given, accepts null.
     *
     * @example PropTypes.string
     */
    public function getString(): PropTypeValidator
    {
        return (new PropTypeValidator())->getString();
    }

    /**
     * Validate that the given string matches the pattern
     *
     * @example PropTypes.arrayOf(PropTypes.string)
     *
     * @param string $regularExpression
     */
    public function regex($regularExpression): PropTypeValidator
    {
        return (new PropTypeValidator())->regex($regularExpression);
    }

    /**
     * Validate the value equals one of the given options.
     *
     * @example PropTypes.oneOf([123, "foo", "bar"])
     *
     * @param mixed[] $values
     */
    public function oneOf(array $values): PropTypeValidator
    {
        return (new PropTypeValidator())->oneOf($values);
    }

    /**
     * Validate an array was given and all validate with the given validator, accepts null.
     *
     * @example PropTypes.arrayOf(PropTypes.string)
     */
    public function arrayOf(ValidatorInterface $itemValidator): PropTypeValidator
    {
        return (new PropTypeValidator())->arrayOf($itemValidator);
    }

    /**
     * Validate the value validates at least with one of the given validators, accepts null.
     *
     * @example PropTypes.anyOf( PropTypes.string, PropTypes.integer )
     */
    public function anyOf(ValidatorInterface ...$validators): PropTypeValidator
    {
        return (new PropTypeValidator())->anyOf(...$validators);
    }

    /**
     * Validate the keys of the given array validate with the assigned Validator, accepts null and ignores all other keys.
     *
     * The key validators have to define wether a single key is required.
     *
     * alias for @see shape
     *
     * @example PropTypes.dataStructure({'foo': PropTypes.integer, 'bar': PropTypes.string})
     *
     * @param array $shape
     */
    public function dataStructure($shape): PropTypeValidator
    {
        return (new PropTypeValidator())->dataStructure($shape);
    }

    /**
     * Validate the keys of the given array validate with the assigned Validator, accepts null and ignores all other keys.
     * The key validators have to define wether a single key is required.
     *
     * alias for @see dataStructure
     *
     * @example PropTypes.shape({'foo': PropTypes.integer, 'bar': PropTypes.string})
     *
     * @param array $shape
     */
    public function shape($shape): PropTypeValidator
    {
        return (new PropTypeValidator())->shape($shape);
    }

    /**
     * Validate that a given value is an existing file.
     *
     * @example PropTypes.fileExists
     */
    public function getFileExists(): PropTypeValidator
    {
        return (new PropTypeValidator())->getFileExists();
    }

    /**
     * Validate the value with the given type, if the value is a Node the NodeType is checked instead of the php-class, accepts null.
     *
     * @example PropTypes.instanceOf('Neos.Neos:Document')
     *
     * @param string $type
     */
    public function instanceOf($type): PropTypeValidator
    {
        return (new PropTypeValidator())->instanceOf($type);
    }

    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
