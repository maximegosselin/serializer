<?php
declare(strict_types = 1);

namespace MaximeGosselin\Serializer\Strategy;

use InvalidArgumentException;

abstract class AbstractDeserializeStrategy implements DeserializeStrategyInterface
{
    /**
     * @throws InvalidArgumentException
     */
    protected function assertValidData($data)
    {
        /* Assert $data is an array */
        if (!is_array($data)) {
            throw new InvalidArgumentException(sprintf('Data must be an array, got %s.', gettype($data)));
        }

        /* Validate type */
        $hasType = array_key_exists('type', $data);
        if (!$hasType) {
            throw new InvalidArgumentException('No value found for key "type".');
        }
        $typeIsString = is_string($data['type'] ?? false);
        if (!$typeIsString) {
            throw new InvalidArgumentException(sprintf(
                'Value for key "type" must be a string, got %s.',
                gettype($data['type'])
            ));
        }
        $type = $data['type'];

        /* Return early if NULL */
        if ($type == 'null') {
            return;
        }

        /* Validate payload presence */
        $hasPayload = array_key_exists('payload', $data);
        if (!$hasPayload) {
            throw new InvalidArgumentException('No value found for key "payload".');
        }
        $payload = $data['payload'];

        /* Validate payload type */
        $payloadIsScalarOrArray = (is_scalar($payload) || is_array($payload));
        if (!$payloadIsScalarOrArray) {
            throw new InvalidArgumentException(sprintf(
                'Value for key "payload" must be scalar or array, got %s.',
                gettype($payload)
            ));
        }

        /* Return if not type object */
        if ($type != 'object') {
            return;
        }

        /* Validate class presence */
        $hasClass = array_key_exists('class', $data);
        if (!$hasClass) {
            throw new InvalidArgumentException('No value found for key "class".');
        }
        $class = $data['class'];

        /* Validate class type */
        $classIsString = is_string($class);
        if (!$classIsString) {
            throw new InvalidArgumentException(sprintf(
                'Value for key "class" must be a string, got %s.',
                gettype($class)
            ));
        }
    }
}
