<?php

namespace ESQ\Test;
use ESQ\Search;
use ESQ\Proxy;

class ProxyTest extends \PHPUnit_Framework_TestCase {

    public function testProxy () {
        $search = new Search();
        //proxy to search object
        $proxy = new Proxy($search);
        //register a test function
        $proxy->register('end', function () {
            return "TestString";
        });

        //expect "TestString"
        $expected = "TestString";

        $this->assertInstanceOf('\\ESQ\\Proxy', $proxy);

        $proxy = $proxy
            ->from(0);//proxy to search, return proxy
        $this->assertInstanceOf('\\ESQ\\Proxy', $proxy);

        $proxy = $proxy
            ->size(25);//proxy to search, return proxy
        $this->assertInstanceOf('\\ESQ\\Proxy', $proxy);

        $actual = $proxy
            ->end();//call on proxy, return  string

        $this->assertEquals($expected, $actual);
    }

}
