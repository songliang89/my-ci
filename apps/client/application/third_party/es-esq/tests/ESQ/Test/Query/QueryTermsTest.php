<?php

namespace ESQ\Test\Query;
use ESQ\Query;

class QueryTermsTest extends \PHPUnit_Framework_TestCase {


    public function testQueryTerm() {
        $q = new Query\TermQuery('field', 'my_val');
        $compiled = $q->compile();
        $expected = array('term' => array(
            'field' => array('value' => 'my_val')
        ));
        $this->assertEquals($expected, $compiled);
    }

    public function testQueryTerms() {
        $q = new Query\TermsQuery('field', array(1,2,3,4,5));
        $compiled = $q->compile();
        $expected = array('terms' => array(
            'field' => array(1,2,3,4,5)
        ));
        $this->assertEquals($expected, $compiled);
    }

}
