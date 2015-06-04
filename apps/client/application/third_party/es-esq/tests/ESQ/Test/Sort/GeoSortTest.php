<?php

namespace ESQ\Test\Sort;
use ESQ\Sort\GeoDistanceSort;

class GeoSortTest extends \PHPUnit_Framework_TestCase {


    public function testGeoDistanceSort() {
        $pin = array(12.12, 55.55);
        $s = new GeoDistanceSort('pin', $pin);
        $compiled = $s->compile();
        $expected = array('_geo_distance' => array(
            'pin' => $pin,
            'unit' => \ESQ\ESQ::DEFAULT_DISTANCE_UNIT
        ));
        $this->assertEquals($expected, $compiled);
    }

}
