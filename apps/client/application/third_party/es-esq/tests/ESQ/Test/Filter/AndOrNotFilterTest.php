<?php

namespace ESQ\Test\Filter;
use ESQ\Filter;

class AndOrNotFilterTest extends \PHPUnit_Framework_TestCase {


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

    public function testAndFilter() {
        $expected = array('and' => array(
            array('term'=>array('field_a'=>'my_term')),
            array('term'=>array('field_b'=>'my_term'))
        ));
        $filter1 = new \ESQ\Filter\TermFilter('field_a', 'my_term');
        $filter2 = new \ESQ\Filter\TermFilter('field_b', 'my_term');
        $filter = new \ESQ\Filter\AndFilter(array(
            $filter1, $filter2
        ));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);
    }

    public function testOrFilter() {
        $expected = array('or' => array(
            array('term'=>array('field_a'=>'my_term')),
            array('term'=>array('field_b'=>'my_term'))
        ));
        $filter1 = new \ESQ\Filter\TermFilter('field_a', 'my_term');
        $filter2 = new \ESQ\Filter\TermFilter('field_b', 'my_term');
        $filter = new \ESQ\Filter\OrFilter(array(
            $filter1, $filter2
        ));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);
    }

    public function testNotFilter() {
        $expected = array('not' => array(
            array('term'=>array('field_a'=>'my_term')),
            array('term'=>array('field_b'=>'my_term'))
        ));
        $filter1 = new \ESQ\Filter\TermFilter('field_a', 'my_term');
        $filter2 = new \ESQ\Filter\TermFilter('field_b', 'my_term');
        $filter = new \ESQ\Filter\NotFilter(array(
            $filter1, $filter2
        ));
        $compiled = $filter->compile();
        $this->assertEquals($expected, $compiled);
    }


}
