# PackageFactory.AtomicFusion.PropTypes

> Validate the props passed to a component via `@propType` annotation

The syntax for the propType annotation is derived from react-propTypes.

ATTENTION: This package is by default only active in development-context.

```
prototype(Vendor.Site:Example) < prototype(Neos.Fusion:Component) {
    @propTypes {

        flag = ${PropTypes.boolean.isRequired}

        string = ${PropTypes.string.isRequired}

        integer = ${PropTypes.integer.isRequired}

        regex = ${PropTypes.regex('/.*regex.*/').isRequired}

        fooOrBar = ${PropTypes.oneOf(["foo", "bar"]).isRequired}

        arrayOfIntegers = ${PropTypes.arrayOf( PropTypes.integer )}

        shape = ${PropTypes.shape({'foo': PropTypes.integer, 'bar': PropTypes.string}).isRequired}

        stringOrInt = ${PropTypes.anyOf(PropTypes.string, PropTypes.integer).isRequired}

        flowQuery = ${PropTypes.flowQuery('[instanceof Neos.Neos:Document]').isRequired}

        instance = ${PropTypes.instanceOf('Neos.Neos:Document').isRequired}
    }
}
```

This will validate the given props with the validator that created in the @propTypes section
via.

## Methods that are supported by the propTypes helper

* `PropTypes.isRequired`:
   Use notEmpty validator to ensure that a value is given.
* `PropTypes.boolean`:
   Validate that a boolean value is given, accepts null.
* `PropTypes.integer`:
   Validate that an integer is given, accepts null.
* `PropTypes.float`:  
   Validate that an float is given, accepts null.
* `PropTypes.string`:  
   Validate that an string is given, accepts null.
* `PropTypes.resourcePath`:
   Validate that a valid resourePath is given, accepts null.
* `PropTypes.regex('/pattern/')`:
   Validate that the given string matches the pattern
* `PropTypes.oneOf([123, "foo", "bar"])`:
   Validate the value equals one of the given options.
* `PropTypes.arrayOf( PropTypes.string )`:
   Validate an array was given and all validate with the given validator, accepts null.
* `PropTypes.anyOf( PropTypes.string, PropTypes.integer )`:
   Validate the value validates at least with one of the given validators, accepts null..
* `PropTypes.shape({'foo': PropTypes.integer, 'bar': PropTypes.string})`:
   Validate the keys of the given array validate with the assigned Validator,
   accepts null and ignores all other keys. The key validators have to define wether a single key is required.
* `PropTypes.instanceOf('Neos.Neos:Document')`:
   Validate the value with the given flowQuery-filter, accepts null.

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

## Settings

The propType-validation is enabled via settings. By default this setting is enabled for
`Development` and `Testing` context but not enabled for `Production`.  

```yaml
PackageFactory:
  AtomicFusion:
    PropTypes:
      enable: false
```

## License

see [LICENSE file](LICENSE)
