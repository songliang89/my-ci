<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: linzl
 * Date: 14-10-9
 * Time: 下午6:04
 */
$config = array(
    'es' => array(
        'connectionClass'        => '\Elasticsearch\Connections\GuzzleConnection',
        'connectionFactoryClass' => '\Elasticsearch\Connections\ConnectionFactory',
        'connectionPoolClass'    => '\Elasticsearch\ConnectionPool\StaticNoPingConnectionPool',
        'selectorClass'          => '\Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector',
        'serializerClass'        => '\Elasticsearch\Serializers\SmartSerializer',
        'sniffOnStart'           => FALSE,
        'connectionParams'       => array(),
        'logging'                => TRUE,
        'logObject'              => NULL,
        'logPath'                =>'elasticsearch.log',
        'logLevel'               => Psr\Log\LogLevel::INFO,
        'traceObject'            => NULL,
        'tracePath'              => 'elasticsearch.log',
        'traceLevel'             => Psr\Log\LogLevel::INFO,
        'guzzleOptions'          => array(),
        'connectionPoolParams'   => array(
            'randomizeHosts' => TRUE
        ),
        'hosts'                  => array(
	        'smzdm_es-search-01:9200',
	        'smzdm_es-search-02:9200',
	        'smzdm_es-search-03:9200'
        ),
        'retries'                => NULL
    )
);