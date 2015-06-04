<?php

namespace ESQ\Test\Filter;
use ESQ\Filter;

class GeoFilterTest extends \PHPUnit_Framework_TestCase {

    public function testGeoDistanceFilter() {
        $expected = array('geo_distance' => array(
            'distance' => '100km',
            'poi.location' => array(12.12, 55.55),
        ));
        $filter = new \ESQ\Filter\GeoDistanceFilter('poi.location', 100, array(12.12, 55.55));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);


        $expected = array('geo_distance' => array(
            'distance' => '100.2000km',
            'poi.location' => array(12.12, 55.55),
        ));
        $filter = new \ESQ\Filter\GeoDistanceFilter('poi.location', 100.2, array(12.12, 55.55));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);


        $expected = array('geo_distance' => array(
            'distance' => '100.22222km',
            'poi.location' => array(12.12, 55.55),
            'distance_type' => 'sloppy_arc',
        ));
        $filter = new \ESQ\Filter\GeoDistanceFilter(
            'poi.location', "100.22222", array(12.12, 55.55), array('distance_type' => 'sloppy_arc'));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);
    }

    public function testGeoDistanceRangeFilter() {
        $expected = array('geo_distance_range' => array(
            'from' => '100km',
            'to' => '200km',
            'poi.location' => array(12.12, 55.55),
        ));
        $filter = new \ESQ\Filter\GeoDistanceRangeFilter('poi.location', 100, 200, array(12.12, 55.55));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);


        $expected = array('geo_distance_range' => array(
            'from' => '100.2000km',
            'to' => '200.2000km',
            'poi.location' => array(12.12, 55.55),
        ));
        $filter = new \ESQ\Filter\GeoDistanceRangeFilter('poi.location', 100.2, 200.2, array(12.12, 55.55));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);


        $expected = array('geo_distance_range' => array(
            'from' => '100.22222km',
            'to' => '200.22222km',
            'poi.location' => array(12.12, 55.55),
        ));
        $filter = new \ESQ\Filter\GeoDistanceRangeFilter('poi.location', "100.22222km", "200.22222km", array(12.12, 55.55));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);

    }

}
