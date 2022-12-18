<?php

namespace UseTheFork\LaravelCast;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use NumberFormatter;

class Cast
{
    use Macroable;

    /**
     * return a boolean value
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public static function boolean(mixed $value)
    {
        $boolval = is_string($value)
            ? filter_var(
                $value,
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            )
            : (bool) $value;

        return $boolval === null ? false : $boolval;
    }

    /**
     * return a array of date values formated in various ways
     *
     * @param mixed $value
     *
     * @return array
     */
    public static function carbonize(string|int $value): array
    {
        $carbonDate = static::date($value);

        $date = [];
        $date["date"] = $carbonDate->format("Y-m-d");
        $date["week"] = $carbonDate->format("Y-W");
        $date["quarter"] =
            $carbonDate->format("Y") . "-" . $carbonDate->quarter;
        $date["month_year"] = $carbonDate->format("Y-m");
        $date["month"] = self::string($carbonDate->format("F"), true);
        $date["year"] = $carbonDate->format("Y");
        $date["hour"] = $carbonDate->format("H");
        $date["day"] = self::string($carbonDate->format("N-D"), true);

        return $date;
    }

    /**
     * return a date value
     *
     * @param mixed $value
     *
     * @return Carbon
     */
    public static function date(
        mixed $value,
        string $format = null,
        string $timezone = "America/New_York"
    ) {
        $value = Carbon::parse($value, $timezone);

        return $format === null ? $value : $value->format($format);
    }

    /**
     * return a string value
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function string(mixed $value, $lower = false)
    {
        return (string) $lower === false ? $value : Str::lower($value);
    }

    /**
     * return a float value
     *
     * @param mixed $value
     *
     * @return float
     */
    public static function float(mixed $value, int $precision = 2)
    {
        return round(
            floatval(preg_replace("/[^-0-9\.]/", "", (string) $value)),
            $precision
        );
    }

    /**
     * return a int value
     *
     * @param mixed $value
     *
     * @return int
     */
    public static function int(mixed $value)
    {
        return intval($value);
    }

    /**
     * return a validated phone number as string
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public static function phone($phone)
    {
        if (empty($phone)) {
            return null;
        }

        $format =
            "/(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/";

        $alt_format =
            '/^(\+\s*)?((0{0,2}1{1,3}[^\d]+)?\(?\s*([2-9][0-9]{2})\s*[^\d]?\s*([2-9][0-9]{2})\s*[^\d]?\s*([\d]{4})){1}(\s*([[:alpha:]#][^\d]*\d.*))?$/';

        // Trim & Clean extension
        $phone = trim($phone);
        $phone = preg_replace(
            "/\s+(#|x|ext(ension)?)\.?:?\s*(\d+)/",
            ' ext \3',
            $phone
        );

        if (preg_match($alt_format, $phone, $matches)) {
            return self::string(
                "(" .
                    $matches[4] .
                    ") " .
                    $matches[5] .
                    "-" .
                    $matches[6] .
                    (!empty($matches[8]) ? " " . $matches[8] : "")
            );
        } elseif (preg_match($format, $phone, $matches)) {
            // format
            $phone = preg_replace($format, "($2) $3-$4", $phone);

            // Remove likely has a preceding dash
            $phone = ltrim($phone, "-");

            // Remove empty area codes
            if (false !== strpos(trim($phone), "()", 0)) {
                $phone = ltrim(trim($phone), "()");
            }

            // Trim and remove double spaces created
            return self::string(preg_replace("/\\s+/", " ", trim($phone)));
        }

        return null;
    }

    /**
     * return a URL value
     *
     * @param mixed $value
     *
     * @return string
     */
    public static function url(mixed $value)
    {
        return self::string(filter_var($value, FILTER_VALIDATE_URL));
    }

    /**
     * return a formated dollar value
     *
     * @param mixed $value
     *
     * @return array
     */
    public static function usd(string|float $value): string
    {
        return (new NumberFormatter(
            "en_US",
            NumberFormatter::CURRENCY
        ))->formatCurrency($value, "USD");
    }
}
