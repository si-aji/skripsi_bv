<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apriori extends Model
{
    public function combinations($arrays, $i = 0) {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = $this->combinations($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }

    function get_combinations($arrays) {
        $result = array(array());
        // foreach ($arrays as $property => $property_values) {
        //     $tmp = array();
        //     foreach ($result as $result_item => $result_values) {
        //         // $tmp[] = array_merge($property_values, array($result_item => $result_values));
        //         foreach ($property_values as $property_value) {
        //             $tmp[] = array_merge($result_item, array($property => $property_value));
        //         }
        //     }
        //     $result = $tmp;
        // }

        foreach ($arrays as $element){
            foreach ($result as $combination){
                array_push($result, array_merge(array($element), $combination));
            }
        }

        return $arrays;
    }
}
