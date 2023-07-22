<?php

namespace PageMakerDev;

use PageMakerDev\Contract\Registry as RegistryInterface;

/**
 * @class A registry to store values, checking their type.
 *
 * A type can be:
 * A type alias, like int for integer
 * A simple type, like a scalar or array
 * A fully-qualified class or interface name
 */
class Registry implements RegistryInterface
{
    /**
     * Mapping of common type names to their PHP internal representation.
     *
     * @const array
     */
    protected const TYPE_ALIASES = [
        'bool' => 'boolean',
        'float' => 'double',
        'int' => 'integer',
    ];

    /**
     * Internal storage for the registry.
     *
     * @var array
     */
    protected $registry = [];

    public function set(string $key, string $type, $value): void
    {
        if (!$this->hasType($type, $value)) {
            throw new LibraryException("Invalid type for key $key. Expected $type, got " . gettype($value));
        }

        if (!isset($this->registry[$key])) {
            $this->registry[$key] = $value;
        } else {
            throw new LibraryException("There is already an entry for key $key");
        }
    }

    public function get(string $key)
    {
        if (isset($this->registry[$key])) {
            return $this->registry[$key];
        } else {
            throw new LibraryException("No entry for key $key");
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

    protected function hasType(string $type, $value): bool
    {
        $actualType = gettype($value);

        // Check object type.
        if ($actualType == 'object') {
            if (in_array($type, class_parents($x))) {
                // It's a subclass
                return true;
            } elseif (in_array($type, class_implements($x))) {
                // It's an interface
                return true;
            }
        }

        // Replace type with its alias if it exists
        if (array_key_exists($type, self::TYPE_ALIASES)) {
            $type = self::TYPE_ALIASES[$type];
        }

        // Check any type.
        if ($type == $actualType) {
            return true;
        }

        return false;
    }
}
