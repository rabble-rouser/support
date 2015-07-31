<?php namespace Rabble\Support;

class Arr
{

    /**
     * Get a subset of the items from the given array by only returning key:value pairs where keys are in $keys
     *
     * @param  array $array
     * @param  array $keys
     *
     * @return array
     */
    public static function only(array $array, array $keys)
    {
        return array_intersect_key($array, array_flip($keys));
    }

    /**
     * Get a subset of the items from the given array by only returning key:value pairs where keys are not in $keys
     *
     * @param array $array
     * @param array $keys_to_remove
     *
     * @return array
     */
    public static function remove(array $array, array $keys)
    {
        return array_diff_key($array, array_flip($keys));
    }

    /**
     * Order an associative array by key, using $order_array to define the order
     *
     * @param array $array
     * @param array $order_keys
     *
     * @return array
     */
    public static function orderByKeys(array $array, array $order_keys)
    {
        $ordered = [];
        foreach ($order_keys as $key) {
            if (array_key_exists($key, $array)) {
                $ordered[$key] = $array[$key];
                unset($array[$key]);
            }
        }

        return $ordered;
    }

    /**
     * Sort an array of Objects by a property.
     * NOTE: This is an implementation of Quick Sort and is a decent amount faster than usort()
     *
     * @param array  $objects
     * @param string $property
     *
     * @return array
     */
    public static function orderByProperty(array $objects, $property)
    {
        if (empty($objects) || !is_array($objects)) {
            return $objects;
        }

        $cur = 1;
        $stack[1]['l'] = 0;
        $stack[1]['r'] = count($objects) - 1;

        do {
            $l = $stack[$cur]['l'];
            $r = $stack[$cur]['r'];
            $cur--;

            do {
                $i = $l;
                $j = $r;
                $tmp = $objects[(int)(($l + $r) / 2)];

                // Partition the array in two parts.
                // Left from $tmp are with smaller values,
                // Right from $tmp are with bigger ones
                do {
                    while ($objects[$i]->{$property} < $tmp->{$property}) {
                        $i++;
                    }

                    while ($tmp->{$property} < $objects[$j]->{$property}) {
                        $j--;
                    }

                    // Swap elements from the two sides
                    if ($i <= $j) {
                        $w = $objects[$i];
                        $objects[$i] = $objects[$j];
                        $objects[$j] = $w;

                        $i++;
                        $j--;
                    }
                } while ($i <= $j);

                if ($i < $r) {
                    $cur++;
                    $stack[$cur]['l'] = $i;
                    $stack[$cur]['r'] = $r;
                }
                $r = $j;
            } while ($l < $r);
        } while ($cur != 0);

        return $objects;
    }

    /**
     * Given an array of arrays, return an array of all sub array summed based on common keys
     *
     * @param array $array
     *
     * @return array
     */
    public static function sumKeys(array $array)
    {
        $final = [];
        array_walk_recursive($array, function ($item, $key) use (&$final) {
            $final[$key] = isset($final[$key]) ? $item + $final[$key] : $item;
        });

        return $final;
    }

}
