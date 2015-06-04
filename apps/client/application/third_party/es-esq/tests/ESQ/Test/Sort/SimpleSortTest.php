<?php

namespace ESQ\Test\Sort;
use ESQ\Sort\SimpleSort;

class SimpleSortTest extends \PHPUnit_Framework_TestCase {

    public function testSimpleSort() {
        $s = new SimpleSort('points', array('order' => 'desc'));
        $compiled = $s->compile();
        $expected = array('points' => array(
            'order' => 'desc'
        ));
        $this->assertEquals($expected, $compiled);
    }

    public function testSimpleSortAdditionalOptions() {
        $s = new SimpleSort('points', array('order' => 'desc', 'some_flag' => true));
        $compiled = $s->compile();
        $expected = array('points' => array(
            'order' => 'desc',
            'some_flag' => true
        ));
        $this->assertEquals($expected, $compiled);
    }

    public function testSimpleSortSortcut() {
        $s = new SimpleSort('points', 'desc');
        $compiled = $s->compile();
        $expected = array('points' => array(
            'order' => 'desc'
        ));
        $this->assertEquals($expected, $compiled);
    }


}
