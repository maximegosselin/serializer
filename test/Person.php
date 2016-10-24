<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Test;

use MaximeGosselin\Serializer\DeserializableInterface;
use MaximeGosselin\Serializer\SerializableInterface;

class Person implements SerializableInterface, DeserializableInterface
{
    private $name;

    private $age;

    private $father;

    public function __construct(string $name, int $age, Person $father = null)
    {
        $this->name = $name;
        $this->age = $age;
        $this->father = $father;
    }

    public function serialize():array
    {
        return [
            'name' => $this->name,
            'age' => $this->age,
            'father' => $this->father
        ];
    }

    public static function deserialize(array $data):Person
    {
        $name = $data['name'];
        $age = $data['age'];
        $father = $data['father'];
        return new static($name, $age, $father);
    }
}
