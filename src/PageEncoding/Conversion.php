<?php
namespace PageEncoding;

use ForceUTF8\Encoding;

/**
 * Class Encoding
 *
 * Temporary helper class as long as webpage and database don't use the same encodings or have to be converted.
 *
 * @package PageEncodingConversion
 */
class Conversion
{
    const PAGE_ENCODING = 'ISO-8859-1'; // or "UTF-8"
    
    const DATABASE_ENCODING = 'latin1'; // or "utf8"

    /**
     * Convert data coming from the page before saving it into the database.
     *
     * @param array|string $data
     * @return array|string
     */
    public static function toDatabase($data)
    {
        if ((self::PAGE_ENCODING == 'UTF-8') && (self::DATABASE_ENCODING == 'latin1')) {
            return Encoding::toLatin1($data);
        } elseif ((self::PAGE_ENCODING == 'ISO-8859-1') && (self::DATABASE_ENCODING == 'utf8')) {
            return Encoding::toUTF8($data);
        }

        return $data;
    }

    /**
     * Convert data coming from the database before displaying it on the page.
     *
     * @param array|string $data
     * @return array|string
     */
    public static function fromDatabase($data)
    {
        if ((self::PAGE_ENCODING == 'UTF-8') && (self::DATABASE_ENCODING == 'latin1')) {
            return Encoding::toUTF8($data);
        } elseif ((self::PAGE_ENCODING == 'ISO-8859-1') && (self::DATABASE_ENCODING == 'utf8')) {
            return Encoding::toISO8859($data);
        }

        return $data;
    }

    /**
     * Convert data coming from a request (e.g. AJAX/JSON) into the page encoding.
     *
     * @param array|string $data
     * @return array|string
     */
    public static function toPage($data)
    {
        if (self::PAGE_ENCODING == 'UTF-8') {
            return Encoding::toUTF8($data);
        }

        return Encoding::toISO8859($data);
    }

    /**
     * @param array|string $data
     * @return array|string
     */
    public static function toUtf8($data)
    {
        return Encoding::toUTF8($data);
    }

    /**
     * @return string
     */
    public static function getPageEncoding()
    {
        return self::PAGE_ENCODING;
    }

    /**
     * @return string
     */
    public static function getDatabaseEncoding()
    {
        return self::DATABASE_ENCODING;
    }

    /**
     * Replace all those f***ing word special characters.
     *
     * @param null|string $string
     * @return bool|mixed
     */
    public static function sanitizeString($string)
    {
        if (empty($string)) {
            return $string;
        }

        $string = self::toUtf8($string);

        //-> Replace all of those weird MS Word quotes and other high characters
        $badWordChars = [
            "\xe2\x80\x98" => "'", // left single quote (UTF-8)
            "\xe2\x80\x99" => "'", // right single quote (UTF-8)
            "\xe2\x80\x9c" => '"', // left double quote (UTF-8)
            "\xe2\x80\x9e" => '"', // left double quote (UTF-8)
            "\xe2\x80\x9d" => '"', // right double quote (UTF-8)
            "\xe2\x80\x93" => '-', // hyphen (UTF-8)
            "\xe2\x80\x94" => '&mdash;', // em dash (UTF-8)
            "\xe2\x80\xa6" => '...', // elipses (UTF-8)
            "\xe2\x84\xa2" => '&trade;', // tm (trademark) sign
            chr(153) => '&trade;', // tm (trademark) sign
            "\x84" => '"', // left double quote (ISO-8859-1)
            "\x94" => '"', // right double quote (ISO-8859-1)
        ];

        $newString = str_replace(array_keys($badWordChars), $badWordChars, $string);

        return self::toPage($newString);
    }

    /**
     * Helper function for dumping all characters of a string with it's hex values. Useful for finding word specials.
     *
     * @param $string
     */
    public static function dumpHexValues($string)
    {
        for ($i = 0; $i < strlen($string); $i++) {
            echo $string[$i].': '.dechex(ord($string[$i])).'<br>';
        }
    }
}
