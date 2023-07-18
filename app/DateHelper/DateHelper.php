<?php

namespace PageMaker\DateHelper;

/**
 * Class Date helper
 *
 * This class allows for operations such as formatting a date into a string, parsing a string into a date, getting the
 * difference between two dates, adding days to a date, and subtracting days from a date.
 *
 * Please note that all functions are implemented as static methods. This means you can call these methods without
 * creating an instance of the class:
 *
 * $date = DateHelper::parseDate('2023-06-22');
 * $formattedDate = DateHelper::formatDate($date, 'Y-m-d');
 * $modifiedDate = DateHelper::addDays($date, 5);
 *
 * The DateTime and DateInterval classes and their methods used in the code above are built into PHP, so you don't need
 * to import any special libraries to use them.
 */
class DateHelper
{
    /**
     * Returns a formatted date string
     *
     * @param DateTime $date
     * @param string $format
     * @return string
     */
    public static function formatDate(DateTime $date, string $format = 'Y-m-d H:i:s'): string
    {
        return $date->format($format);
    }

    /**
     * Parses a string into a DateTime object
     *
     * @param string $dateString
     * @return DateTime
     * @throws Exception
     */
    public static function parseDate(string $dateString): DateTime
    {
        return new DateTime($dateString);
    }

    /**
     * Returns the difference between two dates
     *
     * @param DateTime $date1
     * @param DateTime $date2
     * @return DateInterval
     */
    public static function getDifference(DateTime $date1, DateTime $date2): DateInterval
    {
        return $date1->diff($date2);
    }

    /**
     * Adds a number of days to a date
     *
     * @param DateTime $date
     * @param int $days
     * @return DateTime
     */
    public static function addDays(DateTime $date, int $days): DateTime
    {
        $date->modify("+$days days");
        return $date;
    }

    /**
     * Subtracts a number of days from a date
     *
     * @param DateTime $date
     * @param int $days
     * @return DateTime
     */
    public static function subtractDays(DateTime $date, int $days): DateTime
    {
        $date->modify("-$days days");
        return $date;
    }
}
