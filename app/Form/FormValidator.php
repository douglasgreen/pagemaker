<?php

namespace PageMaker\Form;

/**
 * @class Form validator
 *
 * In this PHP class, the FormValidator class includes methods for validating whether a field is empty
 * (validateNotEmpty), validating the format of an email address (validateEmail), validating the length of a string
 * (validateLength), and validating if a string is a number (validateNumber). These methods add error messages to an
 * associative array ($errors) if validation fails.
 *
 * The getErrors method retrieves all error messages. The hasErrors method checks if there are any error messages.
 *
 * The sanitizeString, sanitizeEmail, and sanitizeNumber methods are used to sanitize user input. They remove or encode
 * "illegal" or potentially harmful characters.
 *
 * Use this class by calling the validation methods on your input data and then use the getErrors method to retrieve
 * any validation error messages.
 */
class FormValidator
{
    protected $errors = [];

    public static function sanitizeString(string $input): string
    {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    public static function sanitizeEmail(string $input): string
    {
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }

    public static function sanitizeNumber(string $input): string
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }

    public function validateNotEmpty(string $field, string $input): bool
    {
        if (empty($input)) {
            $this->errors[$field] = 'This field should not be empty';
            return false;
        }

        return true;
    }

    public function validateEmail(string $field, string $input): bool
    {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'Please enter a valid email address';
            return false;
        }

        return true;
    }

    public function validateLength(string $field, string $input, int $min, int $max): bool
    {
        $length = strlen($input);

        if ($length < $min || $length > $max) {
            $this->errors[$field] = "The input length must be between $min and $max characters";
            return false;
        }

        return true;
    }

    public function validateNumber(string $field, string $input): bool
    {
        if (!is_numeric($input)) {
            $this->errors[$field] = 'The input must be a number';
            return false;
        }

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
