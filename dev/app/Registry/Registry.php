<?php

namespace PageMaker\Registry;

use Exception;

/**
 * @class A registry to store values, checking their type.
 */
class Registry implements RegistryInterface
{
    /**
     * Mapping of common type names to their PHP internal representation.
     *
     * @const array
     */
    protected const TYPE_ALIASES = [
        'int' => 'integer',
        'float' => 'double',
        'bool' => 'boolean',
    ];

    /**
     * Internal storage for the registry.
     *
     * @var array
     */
    protected $registry = [];

    public function set(string $key, string $type, $value): void
    {
        // Replace type with its alias if it exists
        if (array_key_exists($type, self::TYPE_ALIASES)) {
            $type = self::TYPE_ALIASES[$type]; // Fixed this line, original had $typeAliases which doesn't exist
        }

        // Check type of the value
        if (gettype($value) !== $type) {
            throw new Exception("Invalid type for key $key. Expected $type, got " . gettype($value));
        }

        if (!isset($this->registry[$key])) {
            $this->registry[$key] = $value;
        } else {
            throw new Exception("There is already an entry for key $key");
        }
    }

    public function get(string $key)
    {
        if (isset($this->registry[$key])) {
            return $this->registry[$key];
        } else {
            throw new Exception("No entry for key $key");
        }
    }

    public function delete(string $key): void
    {
        unset($this->registry[$key]);
    }

    public function has(string $key): bool
    {
        return isset($this->registry[$key]);
    }
}
