<?php

namespace PageMaker;

/**
 * @class In this class:
 *
 * generateInput() generates a form input. The type, name, and value are all required, but you can optionally pass an associative array of other attributes.
 * generateLink() generates a hyperlink. The URL and text are required, but you can optionally pass an associative array of other attributes.
 * escapeHtmlEntities() escapes special HTML characters in a string.
 *
 * All functions use htmlspecialchars() to prevent HTML injection by escaping special characters. The ENT_QUOTES
 * argument makes it convert both double and single quotes, and UTF-8 sets the encoding.
 */
class HtmlHelper
{
    /**
     * Generates a HTML form input.
     *
     * @param string $type The type of the input.
     * @param string $name The name of the input.
     * @param string $value The value of the input.
     * @param array $attributes Optional additional attributes.
     *
     * @return string Generated HTML input.
     */
    public static function generateInput(string $type, string $name, string $value = '', array $attributes = []): string
    {
        $html = '<input type="' . htmlspecialchars($type, ENT_QUOTES, 'UTF-8') . '"';
        $html .= ' name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '"';
        $html .= ' value="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
        foreach ($attributes as $attr => $val) {
            $html .= ' ' . htmlspecialchars($attr, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . '"';
        }
        $html .= ' />';
        return $html;
    }

    /**
     * Generates a HTML link.
     *
     * @param string $url The URL of the link.
     * @param string $text The text of the link.
     * @param array $attributes Optional additional attributes.
     *
     * @return string Generated HTML link.
     */
    public static function generateLink(string $url, string $text, array $attributes = []): string
    {
        $html = '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"';
        foreach ($attributes as $attr => $val) {
            $html .= ' ' . htmlspecialchars($attr, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . '"';
        }
        $html .= '>' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '</a>';
        return $html;
    }

    /**
     * Escapes HTML entities in a string.
     *
     * @param string $string The string to escape.
     *
     * @return string The escaped string.
     */
    public static function escapeHtmlEntities(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
