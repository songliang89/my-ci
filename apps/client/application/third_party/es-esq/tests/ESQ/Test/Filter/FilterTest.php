<?php

namespace ESQ\Test\Filter;
use ESQ\Filter;

class FilterTest extends \PHPUnit_Framework_TestCase {


    public function testCustomFilter() {
        $expected = array(
            'range' => array(
                'field_name' => array('lte' => 0),
            ),
        );
        $filter = new \ESQ\Filter\Filter('range', array(
            'field_name' => array('lte' => 0),
        ));

        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);
    }

    public function testTermsFilter() {
        $expected = array(
            'terms' => array(
                'field_name' => array('a', 'b', 'c'),
            ),
        );
        $filter = new \ESQ\Filter\TermsFilter('field_name', array('a', 'b', 'c'));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);
    }

    public function testTermFilter() {
        $expected = array(
            'term' => array(
                'field_name' => 'my_term'
            ),
        );
        $filter = new \ESQ\Filter\TermFilter('field_name', 'my_term');
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);
    }

    public function testRangeFilter() {
        $expected = array(
            'range' => array(
                'field_name' => array('gte' => 0),
            ),
        );
        $filter = new \ESQ\Filter\RangeFilter('field_name', array('gte' => 0));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);


        $expected = array(
            'range' => array(
                'field_name' => array('gte' => 0, 'lte' => 10),
            ),
        );
        $filter = new \ESQ\Filter\RangeFilter('field_name', array('gte' => 0, 'lte' => 10));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);
    }

}
