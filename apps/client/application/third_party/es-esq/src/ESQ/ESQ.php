<?php

namespace ESQ;

class ESQ {
    //distance postfix is appended to distance if a float or int is passed
    const DEFAULT_DISTANCE_UNIT = 'km';

    /**
     * Given an array of objects, compile the instances of ICompilable and return
     */
    public static function walkCompile(array $compilables) {
        $out = array();
        foreach($compilables as $k => $c) {
            //compile if compilable
            if($c instanceof ICompilable) {
                $out[$k] = $c->compile();
            }
            //recurse if array
            elseif(is_array($c)) {
                $out[$k] = self::walkCompile($c);
            }
            //out as-is
            else {
                $out[$k] = $c;
            }
        }
        return $out;
    }
}
