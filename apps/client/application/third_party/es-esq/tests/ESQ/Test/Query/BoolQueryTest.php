<?php

namespace ESQ\Test\Query;

use ESQ\Query\BoolQuery;
use ESQ\Query\PrefixQuery;

class BoolQueryTest extends \PHPUnit_Framework_TestCase {


    public function testBoolQuery() {
        $q = new BoolQuery(array(
            'must' => new PrefixQuery('my_field', 'my_prefix'),
            'should' => new PrefixQuery('my_field', 'my_prefix'),
            'must_not' => new PrefixQuery('my_field', 'my_prefix'),
        ));
        $compiled = $q->compile();
        $expected = array('bool' => array(
            'must' => array(array('prefix' => array('my_field' => array('value' => 'my_prefix')))),
            'should' => array(array('prefix' => array('my_field' => array('value' => 'my_prefix')))),
            'must_not' => array(array('prefix' => array('my_field' => array('value' => 'my_prefix')))),
        ));
        $this->assertEquals($expected, $compiled);
    }

    public function testBoolQueryChain() {
        $q = new BoolQuery();

        $q  ->must(new PrefixQuery('a', 'my_prefix'))
            ->must(new PrefixQuery('b', 'my_prefix'))
            ->should(new PrefixQuery('c', 'my_prefix'))
            ->must_not(new PrefixQuery('d', 'my_prefix'));

        $compiled = $q->compile();
        $expected = array('bool' => array(
            'must' => array(
                array('prefix' => array('a' => array('value' => 'my_prefix'))),
                array('prefix' => array('b' => array('value' => 'my_prefix'))),
            ),
            'should' => array(
                array('prefix' => array('c' => array('value' => 'my_prefix')))
            ),
            'must_not' => array(
                array('prefix' => array('d' => array('value' => 'my_prefix')))
            ),
        ));
        $this->assertEquals($expected, $compiled);
    }

    public function testBoolMustOnly() {
        $q = new BoolQuery();

        $q  ->must(new PrefixQuery('a', 'my_prefix'))
            ->must(new PrefixQuery('b', 'my_prefix'));

        $compiled = $q->compile();
        $expected = array('bool' => array(
            'must' => array(
                array('prefix' => array('a' => array('value' => 'my_prefix'))),
                array('prefix' => array('b' => array('value' => 'my_prefix'))),
            ),
        ));
        $this->assertEquals($expected, $compiled);
    }

    public function testNestedBool() {
        $b1 = new BoolQuery();
        $b2 = new BoolQuery();

        $b1
            ->must(new PrefixQuery('a', 'v'))
            ->should($b2);

        $b2
            ->must(new PrefixQuery('b', 'v'));

        $compiled = $b1->compile();
        $expected = array('bool' => array(
            'must' => array(
                array('prefix' => array('a' => array('value' => 'v'))),
            ),
            'should' => array(
                array('bool' => array(
                    'must' => array(
                        array('prefix' => array('b' => array('value' => 'v'))),
                    )
                )),
            ),
        ));
        $this->assertEquals($expected, $compiled);
    }

}
