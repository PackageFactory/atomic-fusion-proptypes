# PackageFactory.AtomicFusion.PropTypes
[![Build Status](https://travis-ci.org/PackageFactory/atomic-fusion-proptypes.svg?branch=master)](https://travis-ci.org/PackageFactory/atomic-fusion-proptypes)

> Validate the props passed to a component via `@propType` annotation. The syntax for the propType annotation is derived from react-propTypes.

*ATTENTION: This package is by default only validatin the props in development-context.*

```
prototype(Vendor.Site:Example) < prototype(Neos.Fusion:Component) {
    @propTypes {
        # optional, enforce that only validated props exist
        @strict = true
        # validation rules for props
        title = ${PropTypes.string.isRequired}
        subtitle = ${PropTypes.string}
    }
}
```

This will validate the given props with the validator that created in the @propTypes section
via.

## Fusion Validator Prototypes 

Proptypes can also be specified via fusion objects.

```neosfusion
@propTypes {
    # all props can be marked as required via `@required = true`
    int = PropTypes:Int {
      @required = true
    }
    float = PropTypes:Float
    bool = PropTypes:Bool

    # strings allow to specify an optional `regularExpression`
    string = PropTypes:String {
        regularExpression = '/hello world/'
    }

    # allows array values that satisfy one of the given validators 
    # or equal one of the given values
    arrayOf = PropTypes:ArrayOf {
        int = PropTypes:Int
        float = PropTypes:Float
        value1 = "foo"
        value2 = "bar"
        ...
    }

    # allow values that satisfy one of the given validators
    # or equal one of the given values
    anyOf = PropTypes:AnyOf {
        int = PropTypes:Int
        string = PropTypes:String
        value1 = "foo"
        value2 = "bar"
        ...
    }

    # a nested structure that is valid once all children valídate
    dataStructure = PropTypes:DataStructure {
        title = PropTypes:String
        description = PropTypes:String
        ...
    }

    # a php object that satisfies the given interface
    instanceOf = PropTypes:InstanceOf {
        type = '\DateTimeInterface'
    }

    # data structure validatpr that uses the defined proptypes from another prototype
    forPrototype = PropTypes:ForPrototype {
        prototypeName = "Vendor.Site:Prototype"
    }
}
```

## Methods that are supported by the propTypes helper

* `PropTypes.any`:
   Accepts any value including null.
* `PropTypes.boolean`:
   Validate that a boolean value is given, accepts null.
* `PropTypes.integer`:
   Validate that an integer is given, accepts null.
* `PropTypes.float`:  
   Validate that an float is given, accepts null.
* `PropTypes.string`:  
   Validate that an string is given, accepts null.
* `PropTypes.regex('/pattern/')`:
   Validate that the given string matches the pattern
* `PropTypes.oneOf([123, "foo", "bar"])`:
   Validate the value equals one of the given options.
* `PropTypes.arrayOf( PropTypes.string )`:
   Validate an array was given and all validate with the given validator, accepts null.
* `PropTypes.anyOf( PropTypes.string, PropTypes.integer )`:
   Validate the value validates at least with one of the given validators, accepts null.
* `PropTypes.dataStructure({'foo': PropTypes.integer, 'bar': PropTypes.string})`:
   Validate the keys of the given array validate with the assigned Validator,
   accepts null and ignores all other keys. The key validators have to define wether a single key is required.
* `PropTypes.shape({'foo': PropTypes.integer, 'bar': PropTypes.string})`:
   Validate the keys of the given array validate with the assigned Validator,
   accepts null and ignores all other keys. The key validators have to define wether a single key is required.
* `PropTypes.fileExists`:
   Validate that a given value is an existing file.
* `PropTypes.instanceOf('Neos.Neos:Document')`:
   Validate the value with the given type, if the value is a Node the NodeType is checked instead of the php-class, accepts null.

### Making values mandatory

* `PropTypes.*.isRequired`:
   To ensure a value is given the isRequired-method can be called after the type-validation. 
   This adds an additional notEmpty validator to enforce that a value is given.

## How it works

If the validation is enabled an aspect is wrapped around the evaluate method of Neos.Fusion:Component and
PackageFactory.AtomicFusion:Component implementations.

This aspect will evaluated the keys in the `@propTypes` section wich are expected to return Flow-Validators
(`Neos\Flow\Validation\Validator\ValidatorInterface`). Next the current prop-value ford each key is
evaluated and passed to the validator. If any of the validation results contains errors a fusion-error is thrown.

The `PropTypes`-EelHelper is a wrapper around the `PackageFactory\AtomicFusion\PropTypes\Validators\PropTypeValidator`
which is an EelHelper and Validator at the same time. This Object is creates an compound-validator that is
controlled in a react-propTypes like syntax via eel.

By creating FusionObjects or EelHelpers that return custom validators you can extend this mechanism if needed.

### Strict mode

In strict mode an error is thrown if an unvalidated prop is passed to
a component in development context. This ensures that all props are validated.

To enable strict mode for a component add `@strict = true` to the `@propTypes`.

```
prototype(Vendor.Site:Example) < prototype(Neos.Fusion:Component) {
    @propTypes {
        @strict = true
        ...
    }
}
```

## Settings

The propType-validation is enabled via settings. By default this setting is enabled for
`Development` and `Testing` context but not enabled for `Production`.  

```yaml
PackageFactory:
  AtomicFusion:
    PropTypes:
      enable: false
```
## Installation

PackageFactory.AtomicFusion.PropTypes is available via packagist. Just run `composer require packagefactory/atomicfusion-proptypes`.

We use semantic-versioning so every breaking change will increase the major-version number.

## License

see [LICENSE file](LICENSE)
