<?php

namespace PageMaker\Registry;

/**
 * @interface A registry to store values, checking their type.
 */
interface RegistryInterface
{
    /**
     * Set a value in the registry, checking its type.
     *
     * To overwrite a key without error, delete it first.
     *
     * @param string $key The key under which the value should be stored.
     * @param string $type The expected type of the value.
     * @param mixed $value The value to be stored.
     *
     * @throws Exception If the type of the value doesn't match the expected type or if the key already exists.
     */
    public function set(string $key, string $type, $value): void;

    /**
     * Retrieve a value from the registry by its key.
     *
     * @param string $key The key under which the value is stored.
     *
     * @return mixed The value associated with the key.
     *
     * @throws Exception If no entry exists for the provided key.
     */
    public function get(string $key);

    /**
     * Remove an entry from the registry by its key.
     *
     * @param string $key The key of the entry to be deleted.
     */
    public function delete(string $key): void;

    /**
     * Check if the registry has an entry for a given key.
     *
     * @param string $key The key to check for.
     *
     * @return bool True if the key exists in the registry, false otherwise.
     */
    public function has(string $key): bool;
}
