<?php
if (!function_exists('array_extract')) {
    /**
     *
     * @param	array
     * @param	string
     * @return	mixed	depends on what the array contains
     */
    function array_extract(array &$array, $item)
    {
        $value = '';
        if (array_key_exists($item, $array)) {
            $value = $array[$item];
            unset($array[$item]);
        }
        return $value;
    }
}