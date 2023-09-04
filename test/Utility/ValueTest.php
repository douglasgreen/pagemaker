<?php

namespace PageMaker\Utility\Test;

use PageMaker\LibraryException;
use PageMaker\Utility\Value;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{
    public function testCheckEmailValid(): void
    {
        $this->expectNotToPerformAssertions();
        Value::checkEmail('test@example.com');
    }

    public function testCheckEmailInvalid(): void
    {
        $this->expectException(LibraryException::class);
        $this->expectExceptionMessage('Invalid email format');
        Value::checkEmail('invalid-email');
    }

    public function testCheckPasswordValid(): void
    {
        $this->expectNotToPerformAssertions();
        Value::checkPassword('Test1234');
    }

    public function testCheckPasswordInvalid(): void
    {
        $this->expectException(LibraryException::class);
        $this->expectExceptionMessage('Invalid password');
        Value::checkPassword('Test');
    }

    public function testCheckPhoneNumberValid(): void
    {
        $this->expectNotToPerformAssertions();
        Value::checkPhoneNumber('+123-456-789-012');
    }

    public function testCheckPhoneNumberInvalid(): void
    {
        $this->expectException(LibraryException::class);
        $this->expectExceptionMessage('Invalid phone number');
        Value::checkPhoneNumber('(123)4567890');
    }

    public function testCheckRequiredValid(): void
    {
        $this->expectNotToPerformAssertions();
        Value::checkRequired('Field', 'Value');
    }

    public function testCheckRequiredInvalid(): void
    {
        $this->expectException(LibraryException::class);
        $this->expectExceptionMessage('Field is required');
        Value::checkRequired('Field', '');
    }

    public function testCheckStrictCamelCaseValid(): void
    {
        $this->expectNotToPerformAssertions();
        Value::checkStrictCamelCase('camelCaseTest');
    }

    public function testCheckStrictCamelCaseNotCamelCase(): void
    {
        $this->expectException(LibraryException::class);
        $this->expectExceptionMessage('Not camel case');
        Value::checkStrictCamelCase('CamelCaseTest');
    }

    public function testCheckStrictCamelCaseNotStrict(): void
    {
        $this->expectException(LibraryException::class);
        $this->expectExceptionMessage('Not strict camel case');
        Value::checkStrictCamelCase('camelCCaseTest');
    }
}
