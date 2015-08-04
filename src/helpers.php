<?php
use Rabble\Support\Arr;
use Rabble\Support\Date;
use Rabble\Support\IO;
use Rabble\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Contracts\Support\Htmlable;

if (!function_exists('arr_only')) {
    /**
     * Get a subset of the items from the given array by only returning key:value pairs where keys are in $keys
     *
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    function arr_only(array $array, array $keys)
    {
        return Arr::only($array, $keys);
    }
}

if (!function_exists('arr_remove')) {
    /**
     * Get a subset of the items from the given array by only returning key:value pairs where keys are not in $keys
     *
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    function arr_remove(array $array, array $keys)
    {
        return Arr::remove($array, $keys);
    }
}

if (!function_exists('arr_order_keys')) {
    /**
     * Order an associative array by key, using $order_array to define the order
     *
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    function arr_order_keys(array $array, array $keys)
    {
        return Arr::orderByKeys($array, $keys);
    }
}

if (!function_exists('arr_order_prop')) {
    /**
     * Order an associative array by key, using $order_array to define the order
     *
     * @param array $objects
     * @param       $key
     *
     * @return array
     */
    function arr_order_prop(array $objects, $key)
    {
        return Arr::orderByProperty($objects, $key);
    }
}

if (!function_exists('arr_sum_keys')) {
    /**
     * Given an array of arrays, return an array of all sub array summed based on common keys
     *
     * @param array $array
     *
     * @return array
     */
    function arr_sum_keys(array $array)
    {
        return Arr::sumKeys($array);
    }
}

if (!function_exists('convert_timezone')) {
    /**
     * Convert a given time string, not timestamp, to a new timezone
     *
     * @param string $time
     * @param string $format
     * @param string $old_tz
     * @param string $new_tz
     *
     * @return string
     */
    function convert_timezone($time, $format = 'Y-m-d H:i:s', $old_tz = 'UTC', $new_tz = 'America/Denver')
    {
        return Date::convertTimezone($time, $format, $old_tz, $new_tz);
    }
}

if (!function_exists('date_range')) {
    /**
     * Creates an array of dates between the given start and end dates inclusively
     *
     * @param $start
     * @param $end
     *
     * @return array
     */
    function date_range($start, $end)
    {
        return Date::createDateRangeArray($start, $end);
    }
}

if (!function_exists('timezone_offset')) {
    /**
     * Returns the offset from the origin timezone to the remote timezone, in seconds.
     *
     * @param string $remote_tz
     * @param string $origin_tz
     *
     * @return int
     */
    function timezone_offset($remote_tz = 'America/Denver', $origin_tz = 'UTC')
    {
        return Date::getTimezoneOffset($remote_tz, $origin_tz);
    }
}

if (!function_exists('yesterday_start_end')) {
    /**
     * Get Y-m-d H:i:s timestamps for yesterdays first and last second. Then convert them to UTC.
     *
     * @param string $time
     * @param string $timezone
     *
     * @return object
     */
    function yesterday_start_end($time = 'now', $timezone = 'America/Denver')
    {
        return Date::getYesterdayStartAndEnd($time, $timezone);
    }
}

if (!function_exists('date_range_by_month')) {
    /**
     * Re-index a date range array it so that all dates are grouped by month
     *
     * @param array $range
     * @param string $direction
     *
     * @return array
     */
    function date_range_by_month(array $range, $direction = 'desc')
    {
        return Date::reindexDateRangeByMonth($range, $direction);
    }
}

if (!function_exists('force_data_download')) {
    /**
     * Force a string of data to be downloaded as a file
     *
     * @param string $name
     * @param string $data
     *
     * @return string|void
     */
    function force_data_download($name, $data)
    {
        return IO::forceDataDownload($name, $data);
    }
}

if (!function_exists('force_file_download')) {
    /**
     * Force a file to be downloaded
     *
     * @param string $full_file_path
     *
     * @return string|void
     * @throws \Exception
     */
    function force_file_download($full_file_path)
    {
        return IO::forceFileDownload($full_file_path);
    }
}

if (!function_exists('ensure_length')) {
    /**
     * Ensure the length of a string
     *
     * @param string $string
     * @param int    $length
     *
     * @return string
     */
    function ensure_length($string, $length)
    {
        return Str::ensure_length($string, $length);
    }
}

if (!function_exists('nl')) {
    /**
     * Return a "newline character"
     *
     * @return string
     */
    function nl()
    {
        return Str::newline();
    }
}
