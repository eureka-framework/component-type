# component-type
[![Current version](https://img.shields.io/packagist/v/eureka/component-type.svg?logo=composer)](https://packagist.org/packages/eureka/component-type)
[![Supported PHP version](https://img.shields.io/static/v1?logo=php&label=PHP&message=7.4|8.0|8.1&color=777bb4)](https://packagist.org/packages/eureka/component-type)
![CI](https://github.com/eureka-framework/component-type/workflows/CI/badge.svg)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=eureka-framework_component-type&metric=alert_status)](https://sonarcloud.io/dashboard?id=eureka-framework_component-type)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=eureka-framework_component-type&metric=coverage)](https://sonarcloud.io/dashboard?id=eureka-framework_component-type)

Utils component to manipulate some php type as objects (string...)


## Testing & CI (Continuous Integration)

You can run tests on your side with following commands:
```bash
make tests   # run tests with coverage
make testdox # run tests without coverage reports but with prettified output
```

You also can run code style check or code style fixes with following commands:
```bash
make phpcs   # run checks on check style
make phpcbf  # run check style auto fix
```

To perform a static analyze of your code (with phpstan, lvl 9 at default), you can use the following command:
```bash
make phpstan
make analyze # Same as phpstan but with CLI output as table
```

To ensure you code still compatible with current supported version and futures versions of php, you need to
run the following commands (both are required for full support):
```bash
make php74compatibility # run compatibility check on current minimal version of php we support
make php81compatibility # run compatibility check on last version of php we will support in future
```

And the last "helper" commands, you can run before commit and push is:
```bash
make ci
```
This command clean the previous reports, install component if needed and run tests (with coverage report),
check the code style and check the php compatibility check, as it would be done in our CI.

## Contributing

See the [CONTRIBUTING](CONTRIBUTING.md) file.

## License

This project is currently under The MIT License (MIT). See [LICENCE](LICENSE) file for more information.
