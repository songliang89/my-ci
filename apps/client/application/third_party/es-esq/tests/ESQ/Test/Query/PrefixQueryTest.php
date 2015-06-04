<?php

namespace ESQ\Test\Query;
use ESQ\Query;

class PrefixQueryTest extends \PHPUnit_Framework_TestCase {

    public function testPrefixQuery() {
        $q = new Query\PrefixQuery('field', 'pre');
        $compiled = $q->compile();
        $expected = array('prefix' => array(
            'field' => array('value' => 'pre')
        ));
        $this->assertEquals($expected, $compiled);
    }


}
