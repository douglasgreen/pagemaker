<?php

namespace PageMaker\Utility;

use PageMaker\LibraryException;

class Value
{
    public static function checkEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new LibraryException('Invalid email format');
        }
    }

    public static function checkPassword(string $password): void
    {
        // Must be a minimum of 8 characters,
        // must include at least one upper case letter, one lower case letter, and one numeric digit
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';

        if (!preg_match($pattern, $password)) {
            throw new LibraryException('Invalid password');
        }
    }

    /**
     * Call filter_var($phoneNumber, FILTER_SANITIZE_NUMBER_INT) before this.
     */
    public static function checkPhoneNumber(string $phoneNumber): void
    {
        $pattern = '/^\+?\d+(-\d+)*$/';

        if (!preg_match($pattern, $phoneNumber)) {
            throw new LibraryException('Invalid phone number');
        }
    }

    public static function checkRequired(string $field, string $value): void
    {
        if (empty($value)) {
            throw new LibraryException($field . ' is required');
        }
    }

    public static function checkStrictCamelCase(string $identifier): void
    {
        // Regular expression pattern
        $pattern = '/^[a-z][a-zA-Z0-9]*$/';

        // If the identifier matches the pattern
        if (preg_match($pattern, $identifier)) {
            // Check if there are two consecutive uppercase letters
            if (preg_match('/[A-Z]{2,}/', $identifier)) {
                throw new LibraryException('Not strict camel case');
            }
        } else {
            throw new LibraryException('Not camel case');
        }
    }
}
