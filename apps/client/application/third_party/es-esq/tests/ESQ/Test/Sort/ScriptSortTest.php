<?php

namespace ESQ\Test\Sort;
use ESQ\Sort\ScriptSort;

class ScriptSortTest extends \PHPUnit_Framework_TestCase {


    public function testGeoDistanceSort() {
        $pin = array(12.12, 55.55);
        $s = new ScriptSort('doc["field_name"].value * factor', array('factor' => 1.1));
        $compiled = $s->compile();
        $expected = array('_script' => array(
            'script' => 'doc["field_name"].value * factor',
            'params' => array(
                'factor' => 1.1
            ),
            'type' => 'number',
            'order' => 'asc'
        ));
        $this->assertEquals($expected, $compiled);
    }

}
