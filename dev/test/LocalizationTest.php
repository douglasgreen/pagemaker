<?php

namespace PageMakerDev\Test;

use PageMakerDev\Localization;
use PHPUnit\Framework\TestCase;

class LocalizationTest extends TestCase
{
    protected $localization;

    protected function setUp(): void
    {
        $this->localization = new Localization();
    }

    public function testDefaultLocaleIsEnUS(): void
    {
        $this->assertSame('en_US', $this->localization->getLocale());
    }

    public function testSetLocale(): void
    {
        $this->localization->setLocale('de_DE');
        $this->assertSame('de_DE', $this->localization->getLocale());
    }

    public function testAddTranslations(): void
    {
        $translations = [
            'hello' => 'Hello, World!'
        ];

        $this->localization->addTranslations($translations);
        $this->assertSame('Hello, World!', $this->localization->translate('hello'));
    }

    public function testTranslateWithNonExistentKeyReturnsKey(): void
    {
        $this->assertSame('nonexistent', $this->localization->translate('nonexistent'));
    }

    public function testFormatDate(): void
    {
        $date = new \DateTime('2023-06-22');

        // The exact format would depend on the locale and intl extension,
        // so for the sake of simplicity, we're just checking if the formatted
        // date contains the year 2023.
        $this->assertStringContainsString('2023', $this->localization->formatDate($date));
    }

    public function testFormatNumber(): void
    {
        $number = 1234.56;

        // The exact format would depend on the locale and intl extension,
        // so we're just checking if the formatted number contains '1,234.56' for the 'en_US' locale.
        $this->assertSame('1,234.56', $this->localization->formatNumber($number));
    }
}
