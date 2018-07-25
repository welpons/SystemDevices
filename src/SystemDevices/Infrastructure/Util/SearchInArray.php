<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Infrastructure\Util;

/**
 * Description of SearchInArray
 *
 * @author felix
 */
class SearchInArray 
{
    /**
     * Flatten a multidimensional array
     * 
     * @param type $array
     * @param type $prefix
     * @return type
     */
    public static function flatten($array, $prefix = '') 
    {
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = $result + self::flatten($value, $prefix . $key . '.');
            } else {
                $result[$prefix . $key] = $value;
            }
        }
        
        return $result;
    } 
    
    /**
     * Checks whether a key exist as array key in a multidimensional
     * 
     * @param array $array
     * @param array $search
     * @return boolean
     */
    public static function valueByKey(array $array, string $search) 
    {
        $flattenArray = self::flatten($array);

        $keys = array_keys($flattenArray);
        $result = preg_grep("/{$search}$/i", $keys);
        
        if (!empty($result)) {
            return $flattenArray[current($result)];
        }
        
        return [];
    }    
}
