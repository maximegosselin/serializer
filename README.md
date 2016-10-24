# Serializer

[![Latest Version](https://img.shields.io/github/release/maximegosselin/serializer.svg)](https://github.com/maximegosselin/serializer/releases)
[![Packagist](https://img.shields.io/packagist/v/maximegosselin/serializer.svg)](https://packagist.org/packages/maximegosselin/serializer)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Build Status](https://img.shields.io/travis/maximegosselin/serializer.svg)](https://travis-ci.org/maximegosselin/serializer)
[![Quality Score](https://img.shields.io/scrutinizer/g/maximegosselin/serializer.svg)](https://scrutinizer-ci.com/g/maximegosselin/serializer)
[![Total Downloads](https://img.shields.io/packagist/dt/maximegosselin/serializer.svg)](https://packagist.org/packages/maximegoselin/serializer)

Convert scalar values and objects to arrays.

## System Requirements

This library requires PHP 7.

## Install

Install `serializer` using Composer.

```
$ composer require maximegosselin/serializer
```

## Usage

### Scalar serialization

*Serializer* supports scalars of type `boolean`, `integer`, `float` and `string`.

```php
$output = Serializer::serialize(123);
print_r($output);
```

will output:
```
Array
(
    [type] => integer
    [payload] => 123
)
```

### Object serialization

A userland class must implement `SerializableInterface` and `DeserializableInterface`.

Let's say we have a class `Person` defined like this:

```php
use MaximeGosselin\Serializer\DeserializableInterface;
use MaximeGosselin\Serializer\SerializableInterface;
 
class Person implements SerializableInterface, DeserializableInterface
{
    private $name;
    
    public function __construct(string $name) {
        $this->name = $name;
    }
    
    public function serialize():array {
        return [
            'name' => $this->name
        ];
    }
    
    public static function deserialize(array $data):Person {
        $name = $data['name'];
        return new static($name);            
    }
}
```

```php
$person = new Person('John');

$output = Serializer::serialize($person);
print_r($output);
```

would output:

```
Array
(
    [type] => object
    [class] => Person
    [payload] => Array
        (
            [name] => Array
                (
                    [type] => string
                    [payload] => John
                )
        )
)
```


## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
