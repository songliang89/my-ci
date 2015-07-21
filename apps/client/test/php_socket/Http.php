<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/7/15
 * Time: 上午10:51
 */

namespace Socket;

interface Proto {

    function get();
    function post();
    function conn($url);
    function close();
}

class Http implements Proto
{
    const HTTP_VERSION = 'HTTP/1.1';
    const CRLF = "\r\n";

    private $handle = null;
    private $socketErrorNo = -1;
    private $socketErrorMsg = '';
    private $socketTimeout = 3;

    protected $response = '';  //响应内容
    protected $urlInfo = array();
    protected $line = array();
    protected $header = array();
    protected $body = array();
    public function get()
    {
        $this->setLine('GET');
        $this->request();
        return $this->response;
    }

    public function post()
    {

    }

    public function conn($url)
    {
        // 解析url
        $this->urlInfo = parse_url($url);
        if(!isset($this->urlInfo['port'])) {
            $this->urlInfo['port'] = 80;
        }
        $this->handle = fsockopen($this->urlInfo['host'], $this->urlInfo['port'], $this->socketErrorNo, $this->socketErrorMsg, $this->socketTimeout);
    }

    public function close()
    {
        fclose($this->handle);
    }

    protected function setLine($method = 'GET')
    {
        $this->line['0'] = $method.' '.$this->urlInfo['path']. ' '.self::HTTP_VERSION;
    }

    protected function setHeader($headerLine)
    {
        $this->header[] = $headerLine;
    }

    public function __construct($url)
    {
        $this->conn($url);
        $this->setHeader('Host: '.$this->urlInfo['host']);
    }
    protected function request()
    {
        $request = array_merge($this->line,$this->header, array(''), $this->body, array(''));
        $request = implode(self::CRLF, $request);
        @fwrite($this->handle, $request);
        while(!feof($this->handle)) {
            $this->response .= fread($this->handle, 1024);
        }
        $this->close();
        return $this->response;
    }
}

$url = 'http://www.smzdm.com/';
$http = new Http($url);
$ret = $http->get();
echo $ret;