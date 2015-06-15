<?php

namespace ESQ\Test;
use ESQ;

class SearchQueryTest extends \PHPUnit_Framework_TestCase {

    public function tearDown() {
    }

    public function setUp() {
    }


    public function testSearchQueryConstruct() {
        $search = new \ESQ\Search();
        $this->assertInstanceOf('\ESQ\Search', $search);
    }

    public function testQuery () {
        $search = new \ESQ\Search();
        $search->query(new \ESQ\Query\MatchAllQuery());
        $compiled = $search->compile();
        $this->assertEquals(array('query'=>array('match_all' => new \StdClass())), $compiled);
    }

    public function testCustomSet () {
        $search = new \ESQ\Search();
        $search->query(new \ESQ\Query\MatchAllQuery());
        $search->setKey('k1', true);
        $search->setKey('k2', 1);
        $search->setKey('k3', 'test');

        $compiled = $search->compile();
        $expected = array(
            'k1' => true,
            'k2' => 1,
            'k3' => 'test',
            'query'=>array('match_all' => new \StdClass())
        );
        $this->assertEquals($expected, $compiled);
    }

    public function testFields () {
        $search = new \ESQ\Search();
        $search->query(new \ESQ\Query\MatchAllQuery());
        //test that fields is set as expected
        $search
            //set a field by string
            ->fields("a")
            //set multiple fields by array
            ->fields(array("b", "c"))
            //clear all set fields
            ->fields(null);
        $this->assertArrayNotHasKey('fields', $search->compile());

        $search
            //set some fields again
            ->fields("c")
            ->fields(array("d","e","f"))
            ;
        //assert that fields int he search equals (in the exact order):
        $compiled = $search->compile();
        $this->assertEquals(array("c","d","e","f"), $compiled['fields']);
    }

    public function testCombined () {

        $demoLocation = array(12.12, 55.55);

        //create a new search
        $search = new \ESQ\Search();
        $search
            //pagination
            ->from(0)
            ->size(25)
            //sorting results
            ->sort()//get a SortList proxy
                ->by(new \ESQ\Sort\GeoDistanceSort('pin.location', $demoLocation))
                ->by('_score')
                ->back()//go back to the object that created the SortList (the $search object)
            //custom
            ->setKey('track_scores', true);

        //attach query object. We use a filtered query
        $search->query(new \ESQ\Query\FilteredQuery(
            //that filters out results above 100km
            new ESQ\Filter\GeoDistanceFilter('pin.location', 100, $demoLocation),
            //and searches for the tag "awesome"
            new \ESQ\Query\TermQuery('tag', 'awesome')
        ));

        //compile and json encode
        $compiled = $search->compile();
        $expected = array(
            'sort' => array(
                array('_geo_distance' => array(
                    'pin.location' => array(12.12, 55.55),
                    'unit' => 'km',
                )),
                '_score'
            ),
            'size' => 25,
            'from' => 0,
            'query' => array(
                'filtered' => array(
                    'filter' => array(
                        'geo_distance' => array(
                            'distance' => '100km',
                            'pin.location' => array(12.12, 55.55),
                        ),
                    ),
                    'query' => array(
                        'term' => array(
                            'tag' => array('value' => 'awesome')
                        ),
                    ),
                ),
            ),
            'track_scores' => true,
        );
        $this->assertEquals($expected, $compiled);

    }

}
