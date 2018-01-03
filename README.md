# PackageFactory.AtomicFusion

> Prototypes and Helpers for implementing a component-architecture with Neos.Fusion


```
prototype(Vendor.Site:Foo) < prototype(Neos.Fusion:Component) {
	@propTypes {
		title = ${PropTypes.string.isRequired}
		active = ${PropTypes.boolean}
	}
}
```

Since this will validate all props that are passed to fusion-components.   
This package is by default only active in development-context.

## Supported `@propTypes`

* `required`
* `boolean`
* `integer`
* `float`
* `string`
* `number`
* `regex('/pattern/')`
* `oneOf(123, "foo", "bar")`
* `arrayOf( PropTypes.string )`
* `anyOf( PropTypes.string, PropTypes.integer )`
* `shape( {foo: PropTypes.string} )`

## License

see [LICENSE file](LICENSE)
