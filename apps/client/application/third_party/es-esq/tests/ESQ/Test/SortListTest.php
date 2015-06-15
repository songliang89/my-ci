<?php

namespace ESQ\Test;
use ESQ;

class SortListTest extends \PHPUnit_Framework_TestCase {

    public function testSortBy () {
        $sortList = new \ESQ\Sort\SortList();
        $sortList->by('field_a', 'asc')->by('_score')->by('field_b', 'desc');

        $compiled = $sortList->compile();
        $expected = array(
            array('field_a' => array('order' => 'asc')),
            '_score',
            array('field_b' => array('order' => 'desc')),
        );
        $this->assertEquals($expected, $compiled);
    }

    public function testSortClear () {
        $sortList = new \ESQ\Sort\SortList();
        $sortList->by('a')->clear()->by('b');
        $compiled = $sortList->compile();
        $expected = array('b');
        $this->assertEquals($expected, $compiled);
    }

    public function testSortClearField () {
        $sortList = new \ESQ\Sort\SortList();
        $sortList->by('a')->clear('b')->by('b');
        $compiled = $sortList->compile();
        $expected = array('a','b');
        $this->assertEquals($expected, $compiled);
    }

    public function testSortAddClearAdd () {
        $sortList = new \ESQ\Sort\SortList();
        $sortList
            ->by('a', 'asc')
            ->by('a')
            ->clear('a')
            ->by('b', 'asc')
            ->by('a', 'desc')
            ->by('_score');

        $expected = array(
            array('b' => array('order' => 'asc')),
            array('a' => array('order' => 'desc')),
            '_score'
        );
        $compiled = $sortList->compile();
        $this->assertEquals($expected, $compiled);
    }


}
