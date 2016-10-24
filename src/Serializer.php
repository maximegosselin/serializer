<?php

declare(strict_types = 1);

namespace MaximeGosselin\Serializer;

class Serializer implements SerializerInterface
{
    const SUPPORTED_TYPES = ['boolean', 'integer', 'double', 'string', 'object', 'null'];

    public static function serialize($var):array
    {
        if ($var && !is_scalar($var) && !$var instanceof SerializableInterface) {
            throw new SerializationException(sprintf(
                'To be serialized, variable must be a supported scalar, NULL, or implement %s.',
                SerializableInterface::class
            ));
        }

        if (is_null($var)) {
            return [
                'type' => 'null'
            ];
        }

        if (is_scalar($var)) {
            return [
                'type' => gettype($var),
                'payload' => $var
            ];
        }

        $payload = $var->serialize();
        array_walk($payload, function (&$value) {
            $value = self::serialize($value);
        });

        $serialization = [
            'type' => gettype($var),
            'class' => get_class($var),
            'payload' => $payload
        ];

        return $serialization;
    }

    public static function deserialize(array $data)
    {
        $type = $data['type'] ?? null;
        if (!in_array($type, self::SUPPORTED_TYPES)) {
            throw new DeserializationException(sprintf('Type %s not supported.', $type));
        }

        if ($type == 'null') {
            return null;
        }

        $payload = $data['payload'] ?? [];

        if ($type == 'object') {
            $class = $data['class'] ?? null;

            if (!class_exists($class)) {
                throw new DeserializationException(sprintf('Class %s not found.', $class));
            }

            if (!in_array(DeserializableInterface::class, class_implements($class))) {
                throw new DeserializationException(sprintf(
                    'Class %s must implement %s.',
                    $class,
                    DeserializableInterface::class
                ));
            }

            array_walk($payload, function (&$value) {
                $value = self::deserialize($value);
            });

            return forward_static_call([$class, 'deserialize'], $payload);
        } else {
            if (!settype($payload, $type)) {
                throw new DeserializationException(sprintf(
                    'Could not convert payload type from %s to %s.',
                    gettype($payload),
                    $type
                ));
            }

            return $payload;
        }
    }
}
