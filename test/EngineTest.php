<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Test;

use MaximeGosselin\Serializer\Engine;
use MaximeGosselin\Serializer\Serializer;
use PHPUnit_Framework_TestCase;
use StdClass;

class EngineTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Engine
     */
    protected $engine;

    const SERIALIZED_BOOLEAN = [
        'type' => 'boolean',
        'payload' => true
    ];

    const SERIALIZED_INTEGER = [
        'type' => 'integer',
        'payload' => 123
    ];

    const SERIALIZED_DOUBLE = [
        'type' => 'double',
        'payload' => 3.14159
    ];

    const SERIALIZED_STRING = [
        'type' => 'string',
        'payload' => 'foo'
    ];

    const SERIALIZED_NULL = [
        'type' => 'null'
    ];

    const UNSERIALIZED_ARRAY = [
        123,
        'pi' => 3.14159,
        'foo',
        null,
        [false]
    ];

    const SERIALIZED_ARRAY = [
        'type' => 'array',
        'payload' => [
            0 => [
                'type' => 'integer',
                'payload' => 123

            ],
            'pi' => [
                'type' => 'double',
                'payload' => 3.14159
            ],
            1 => [
                'type' => 'string',
                'payload' => 'foo'
            ],
            2 => [
                'type' => 'null'
            ],
            3 => [
                'type' => 'array',
                'payload' => [
                    0 => [
                        'type' => 'boolean',
                        'payload' => false
                    ]
                ]
            ]
        ]
    ];

    const SERIALIZED_OBJECT = [
        'type' => 'object',
        'class' => Person::class,
        'payload' => [
            'name' => [
                'type' => 'string',
                'payload' => 'John'
            ],
            'age' => [
                'type' => 'integer',
                'payload' => 27
            ],
            'father' => [
                'type' => 'object',
                'class' => Person::class,
                'payload' => [
                    'name' => [
                        'type' => 'string',
                        'payload' => 'Bill'
                    ],
                    'age' => [
                        'type' => 'integer',
                        'payload' => 58
                    ],
                    'father' => [
                        'type' => 'null'
                    ]
                ]
            ]
        ]
    ];

    /**
     * @var Person
     */
    protected $person;

    public function setUp()
    {
        $this->engine = new Engine();
        $this->person = new Person('John', 27, new Person('Bill', 58));
        parent::setUp();
    }

    public function testSerializeBoolean()
    {
        $this->assertArraySubset(self::SERIALIZED_BOOLEAN, $this->engine->serialize(true));
    }

    public function testDeserializeBoolean()
    {
        $this->assertSame(true, $this->engine->deserialize(self::SERIALIZED_BOOLEAN));
    }

    public function testSerializeInteger()
    {
        $this->assertArraySubset(self::SERIALIZED_INTEGER, $this->engine->serialize(123));
    }

    public function testDeserializeInteger()
    {
        $this->assertSame(123, $this->engine->deserialize(self::SERIALIZED_INTEGER));
    }

    public function testSerializeDouble()
    {
        $this->assertArraySubset(self::SERIALIZED_DOUBLE, $this->engine->serialize(3.14159));
    }

    public function testDeserializeDouble()
    {
        $this->assertSame(3.14159, $this->engine->deserialize(self::SERIALIZED_DOUBLE));
    }

    public function testSerializeString()
    {
        $this->assertArraySubset(self::SERIALIZED_STRING, $this->engine->serialize('foo'));
    }

    public function testDeserializeString()
    {
        $this->assertSame('foo', $this->engine->deserialize(self::SERIALIZED_STRING));
    }

    public function testSerializeNull()
    {
        $this->assertArraySubset(self::SERIALIZED_NULL, $this->engine->serialize(null));
    }

    public function testDeserializeNull()
    {
        $this->assertNull($this->engine->deserialize(self::SERIALIZED_NULL));
    }

    public function testSerializeArray()
    {
        $this->assertArraySubset(
            self::SERIALIZED_ARRAY,
            $this->engine->serialize(self::UNSERIALIZED_ARRAY)
        );
    }

    public function testDeserializeArray()
    {
        $this->assertArraySubset(
            self::UNSERIALIZED_ARRAY,
            $this->engine->deserialize(self::SERIALIZED_ARRAY)
        );
    }

    /**
     * @expectedException \MaximeGosselin\Serializer\SerializationException
     */
    public function testSerializeUnsupportedObjectThrowsSerializationException()
    {
        $this->engine->serialize(new StdClass());
    }

    public function testSerializeObjectImplementingSerializableInterface()
    {
        $this->assertArraySubset(self::SERIALIZED_OBJECT, $this->engine->serialize($this->person));
    }

    /**
     * @expectedException \MaximeGosselin\Serializer\DeserializationException
     */
    public function testDeserializeInvalidDataThrowsDeserializationException()
    {
        $this->engine->deserialize([123]);
    }

    public function testDeserializeObjectImplementingSerializableInterface()
    {
        $this->assertEquals($this->person, $this->engine->deserialize(self::SERIALIZED_OBJECT));
    }
}
