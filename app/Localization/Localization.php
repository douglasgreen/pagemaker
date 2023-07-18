<?php

namespace PageMaker\Localization;

/**
 * @class
 * This is a basic implementation and it does not contain any actual translations or complex localization logic. For a
 * complete solution, you would need to have a translation mechanism in place, such as gettext, or use a PHP library
 * for internationalization.
 *
 * You can use this class as follows:
 *
 * $localization = new Localization('en_US');
 * $localization->addTranslations(['hello' => 'Hello, World!']);
 * echo $localization->translate('hello');
 *
 * $localization->setLocale('de_DE');
 * $localization->addTranslations(['hello' => 'Hallo, Welt!']);
 * echo $localization->translate('hello');
 *
 * $date = new \DateTime('2023-06-22');
 * echo $localization->formatDate($date);
 *
 * $number = 1234.56;
 * echo $localization->formatNumber($number);
 *
 * Remember to install the `intl` extension in your PHP installation, as it is used for number and date formatting.
 */
class Localization
{
    // The current locale
    protected $locale;

    // Array to hold translations
    protected $translations = [];

    // Construct the Localization with a default locale
    public function __construct(string $locale = 'en_US')
    {
        $this->locale = $locale;
        setlocale(LC_ALL, $this->locale);
    }

    // Set a new locale
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
        setlocale(LC_ALL, $this->locale);
    }

    // Get the current locale
    public function getLocale(): string
    {
        return $this->locale;
    }

    // Add translations to the class
    public function addTranslations(array $translations): void
    {
        $this->translations = array_merge($this->translations, $translations);
    }

    // Translate a string
    public function translate(string $key): string
    {
        return $this->translations[$key] ?? $key;
    }

    // Format a date/time for the current locale
    public function formatDate(\DateTime $date): string
    {
        $formatter = new IntlDateFormatter($this->locale, IntlDateFormatter::LONG, IntlDateFormatter::LONG);
        return $formatter->format($date);
    }

    // Format a number for the current locale
    public function formatNumber(float $number): string
    {
        $formatter = new NumberFormatter($this->locale, NumberFormatter::DECIMAL);
        return $formatter->format($number);
    }
}
