<?php

namespace PageMaker;

use Exception;

class Validator
{
    public static function checkStrictCamelCase(string $identifier): void
    {
        // Regular expression pattern
        $pattern = '/^[a-z][a-zA-Z0-9]*$/';

        // If the identifier matches the pattern
        if (preg_match($pattern, $identifier)) {
            // Check if there are two consecutive uppercase letters
            if (preg_match('/[A-Z]{2,}/', $identifier)) {
                throw new Exception('Not strict camel case');
            }
        } else {
            throw new Exception('Not camel case');
        }
    }

    public static function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }
    }

    public static function validatePhoneNumber(string $phoneNumber): void
    {
        // This pattern is for US phone numbers only
        // You may want to use a different pattern depending on your country
        $pattern = '/^\+1[2-9]\d{2}[2-9]\d{2}\d{4}$/';

        if (!preg_match($pattern, $phoneNumber)) {
            throw new Exception('Invalid phone number');
        }
    }

    public static function validatePassword(string $password): void
    {
        // Must be a minimum of 8 characters,
        // must include at least one upper case letter, one lower case letter, and one numeric digit
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';

        if (!preg_match($pattern, $password)) {
            throw new Exception('Invalid password');
        }
    }

    public static function validateRequired(string $field, string $value): void
    {
        if (empty($value)) {
            throw new Exception($field . ' is required');
        }
    }
}
