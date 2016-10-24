<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Test;

use MaximeGosselin\Serializer\Serializer;
use PHPUnit_Framework_TestCase;
use StdClass;

class SerializerTest extends PHPUnit_Framework_TestCase
{
    public function testSerializeBooleanScalar()
    {
        $this->assertArraySubset(['type' => 'boolean', 'payload' => false], Serializer::serialize(false));
        ;
    }

    public function testDeserializeBooleanScalar()
    {
        $this->assertInternalType('boolean', Serializer::deserialize(['type' => 'boolean', 'payload' => false]));
    }

    public function testSerializeIntegerScalar()
    {
        $this->assertArraySubset(['type' => 'integer', 'payload' => 123], Serializer::serialize(123));
        ;
    }

    public function testDeserializeIntegerScalar()
    {
        $this->assertInternalType('integer', Serializer::deserialize(['type' => 'integer', 'payload' => 123]));
    }

    public function testSerializeDoubleScalar()
    {
        $this->assertArraySubset(['type' => 'double', 'payload' => 3.1416], Serializer::serialize(3.1416));
        ;
    }

    public function testDeserializeDoubleScalar()
    {
        $this->assertInternalType('double', Serializer::deserialize(['type' => 'double', 'payload' => 3.1416]));
    }

    public function testSerializeStringScalar()
    {
        $this->assertArraySubset(['type' => 'string', 'payload' => 'foo'], Serializer::serialize('foo'));
        ;
    }

    public function testDeserializeStringScalar()
    {
        $this->assertInternalType('string', Serializer::deserialize(['type' => 'string', 'payload' => 'foo']));
    }

    public function testSerializeNull()
    {
        $this->assertArraySubset(['type' => 'null'], Serializer::serialize(null));
        ;
    }

    public function testDeserializeNull()
    {
        $this->assertNull(Serializer::deserialize(['type' => 'null']));
    }

    /**
     * @expectedException \MaximeGosselin\Serializer\SerializationException
     */
    public function testSerializeUnsupportedObjectThrowsSerializationException()
    {
        Serializer::serialize(new StdClass());
    }

    public function testSerializeObjectImplementingSerializableInterface()
    {
        $person = new Person('John', 27, new Person('Bill', 58));

        $this->assertArraySubset([
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
        ], Serializer::serialize($person));
    }

    public function testDeserializeObjectImplementingSerializableInterface()
    {
        $person = new Person('John', 27, new Person('Bill', 58));

        $this->assertEquals($person, Serializer::deserialize([
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
        ]));
    }
}
