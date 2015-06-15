<?php

namespace ESQ\Filter;

/**
 * 
 */
abstract class AbstractGeoFilter extends AbstractFilter {


    /**
     * Convert int, float or string to valid distance string
     */
    public function parseDistance($distance) {
        $parsed = null;
        //if numeric, append distance unit
        if(is_float($distance)) {
            $parsed = sprintf(
                '%0.4f%s', $distance, \ESQ\ESQ::DEFAULT_DISTANCE_UNIT);
        }
        elseif(is_int($distance)) {
            $parsed = sprintf(
                '%d%s', $distance, \ESQ\ESQ::DEFAULT_DISTANCE_UNIT);
        }
        //else, if string but without trailing unit
        elseif(is_string($distance) && !preg_match('/[^\d]+$/', $distance)) {
            $parsed = sprintf('%s%s',
                $distance,
                \ESQ\ESQ::DEFAULT_DISTANCE_UNIT);
        }
        //else if string, and distance
        elseif(is_string($distance) && preg_match('/^([\d]+(\.[\d]+)?)\s*[^\d]+$/', $distance)) {
            $parsed = $distance;
        }
        //else, invalid arg
        else {
            throw new \InvalidArgumentException('invalid distance given. Should be int, float, or numeric string, optionally with unit identifier appended');
        }
        return $parsed;
    }

}
