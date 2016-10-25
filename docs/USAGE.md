# Documentation

*Serializer* is used to convert variables to a portable array structure than can be easily exported outside your application.

The following variable types are supported: `boolean`, `integer`, `double`, `string`, `array`, `object`, `NULL`.

Objects must implement `SerializableInterface` and/or `DeserializableInterface` interfaces.

Arrays must contain only values of supported types.

### Using the `Engine` class

The `Engine` class exposes two functions, `serialize($var)` and `deserialize(array $data)`.

Serializing data back and forth is quite simple:

```php
$engine = new Engine();
 
$result = $engine->serialize('foo');
 
$engine->deserialize($result);  // foo
```

### Custom objects

A userland class must implement `SerializableInterface` and/or `DeserializableInterface`.

For example, a class `MyApp\Person` could be implemented like this:

```php
namespace MyApp;

class Person implements SerializableInterface, DeserializableInterface
{
    private $name;
    
    private $age;
    
    public function __construct(string $name, int $age) {
        $this->name = $name;
        $this->age = $age;
    }
    
    public function serialize():array {
        return [
            'name' => $this->name,
            'age' => $this->age
        ];
    }
    
    public static function deserialize(array $data):Person {
        return new static($data['name'], $data['age']);            
    }
}
```

### Convert to JSON

Since the resulting array returned by `serialize()` contains only scalar values,
it can be converted to JSON with `json_encode()`.  

```php
$person = new \MyApp\Person('John', 27);
 
$result = $engine->serialize($person);
 
echo json_encode($result);
```

This would output:

```
{
    "type": "object",
    "class": "MyApp\Person",
    "payload": {
        "name": {
            "type": "string",
            "payload": "John"
        },
        "age": {
            "type": "integer",
            "payload": 27
        }
    }
}
```
