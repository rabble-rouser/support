<?php namespace Rabble\Support;

use DateInterval;
use DateTime;
use DateTimeZone;

class Date
{

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
    public static function convertTimezone($time, $format = 'Y-m-d H:i:s', $old_tz = 'UTC', $new_tz = 'America/Denver')
    {
        // DateTime variable for our old time string
        $date = new DateTime($time, new DateTimeZone($old_tz));

        // Convert to new timezone
        $date->setTimezone(new DateTimeZone($new_tz));

        return $date->format($format);
    }

    /**
     * Creates an array of dates between the given start and end dates inclusively
     *
     * @param $start
     * @param $end
     *
     * @return array
     */
    public static function createDateRangeArray($start, $end)
    {
        // Insure the format of the passed in dates
        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));

        // Create timestamps(# seconds since epoch) for these dates
        $start_time = mktime(1, 0, 0, substr($start, 5, 2), substr($start, 8, 2), substr($start, 0, 4));
        $end_time = mktime(1, 0, 0, substr($end, 5, 2), substr($end, 8, 2), substr($end, 0, 4));

        $range = [];
        if ($end_time >= $start_time) {
            while ($start_time <= $end_time) {
                array_push($range, date('Y-m-d', $start_time));
                $start_time += 86400; // Add 24 hours
            }
        }

        return $range;
    }

    /**
     * Returns the offset from the origin timezone to the remote timezone, in seconds.
     *
     * @param string $remote_tz
     * @param string $origin_tz
     *
     * @return int
     */
    public static function getTimezoneOffset($remote_tz = 'America/Denver', $origin_tz = 'UTC') {
        $origin_dtz = new DateTimeZone($origin_tz);
        $remote_dtz = new DateTimeZone($remote_tz);
        $origin_dt = new DateTime('now', $origin_dtz);
        $remote_dt = new DateTime('now', $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);

        // Offset is in seconds; we convert to hours.
        $offset = $offset / 60 / 60;

        return $offset;
    }

    /**
     * Get Y-m-d H:i:s timestamps for yesterdays first and last second. Then convert them to UTC.
     *
     * @param string $time
     * @param string $timezone
     *
     * @return object
     */
    public static function getYesterdayStartAndEnd($time = 'now', $timezone = 'America/Denver')
    {
        // Get the $timezone time right now
        $date = new DateTime($time, new DateTimeZone($timezone));

        // Subtract a day - DateInterval::createFromDateString('yesterday') is negative so add it
        $date->add(DateInterval::createFromDateString('yesterday'));

        // Start date is yesterday 00:00:00 $timezone time
        $start = $date->format('Y-m-d 00:00:00');
        $end = $date->format('Y-m-d 23:59:59');

        // Create new DateTime object with these $timezone time, time strings
        $start_date = new DateTime($start, new DateTimeZone($timezone));
        $end_date = new DateTime($end, new DateTimeZone($timezone));

        // Convert to UTC
        $start_date->setTimezone(new DateTimeZone('UTC'));
        $end_date->setTimezone(new DateTimeZone('UTC'));

        // Use the UTC converted full date time string
        $start = $start_date->format('Y-m-d H:i:s');
        $end = $end_date->format('Y-m-d H:i:s');

        return (object)compact('start', 'end');
    }

    /**
     * Re-index a date range array it so that all dates are grouped by month
     *
     * @param array $range
     * @param string $direction
     *
     * @return array
     */
    public static function reindexDateRangeByMonth(array $range, $direction = 'desc')
    {
        // Insure that the date range array is sorted
        sort($range);

        if ($direction == 'desc') {
            // Reverse the date range array so we have the newest date first
            $range = array_reverse($range);
        }

        $reindexed_range = [];
        foreach ($range as $date) {
            $index = date('Y-m', strtotime($date)).'-01';
            if (!isset($reindexed_range[$index])) {
                $reindexed_range[$index] = [];
            }

            // Add this date to the array for this month either on the front or back depending on direction
            if ($direction == 'desc') {
                array_unshift($reindexed_range[$index], $date);
            } else {
                array_push($reindexed_range[$index], $date);
            }
        }

        return $reindexed_range;
    }

}
