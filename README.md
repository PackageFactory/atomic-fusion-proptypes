# PackageFactory.AtomicFusion.PropTypes

> Validate the props passed to a component via `@propType` annotation 

The syntax for the propType annotation is derived from the react-propTypes.

ATTENTION: This package is by default only active in development-context.

```
prototype(Vendor.Site:Example) < prototype(Neos.Fusion:Component) {
    @propTypes {

        flag = ${PropTypes.boolean.isRequired}
        
        string = ${PropTypes.string.isRequired}

        integer = ${PropTypes.integer.isRequired}

        number = ${PropTypes.number.isRequired}

        regex = ${PropTypes.regex('/.*regex.*/').isRequired}

        fooOrBar = ${PropTypes.oneOf("foo", "bar").isRequired}

        arrayOfIntegers = ${PropTypes.arrayOf( PropTypes.integer )}

        shape = ${PropTypes.shape({'foo': PropTypes.integer, 'bar': PropTypes.string}).isRequired}

        stringOrInt = ${PropTypes.anyOf(PropTypes.string, PropTypes.integer).isRequired}
    }   
}
```

This will validate the given props with the validator that created in the @propTypes section 
via. 

## Methods that are supported by the propTypes helper

* `PropTypes.isRequired`
* `PropTypes.boolean`
* `PropTypes.integer`
* `PropTypes.float`
* `PropTypes.string`
* `PropTypes.number`
* `PropTypes.resourcePath`
* `PropTypes.regex('/pattern/')`
* `PropTypes.oneOf(123, "foo", "bar")`
* `PropTypes.arrayOf( PropTypes.string )`
* `PropTypes.anyOf( PropTypes.string, PropTypes.integer )`
* `PropTypes.shape({'foo': PropTypes.integer, 'bar': PropTypes.string})`

## License

see [LICENSE file](LICENSE)
