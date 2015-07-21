<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/7/14
 * Time: 下午4:51
 */

/**
 * http 请求的接口.
 * Interface proto
 */
interface Proto {

    function conn($url);

    function get();

    function post();

    // 关闭连接
    function close();
}

class Socket implements proto
{
    const CRLF = "\r\n"; // 换行符号.
    protected $error = -1; // 错误号
    protected $errmsg = ''; // 错误信息.
    protected $urlInfo = array();
    protected $line = array();
    protected $header = array();
    protected $body = array();
    protected $version = 'HTTP/1.1';
    protected $fh = null;

    // 响应信息.
    protected $response = '';
    /**
     * 声明请求行.
     */
    protected function setLine($method)
    {
        $this->urlInfo['query'] = isset($this->urlInfo['query']) ? $this->urlInfo['query'] : '';
        $this->line[0] = $method. " " .$this->urlInfo['path'].'?'.$this->urlInfo['query'].' '.$this->version;
    }
    /**
     * 声明头信息.
     */
    public function setHeader($headerLine)
    {
        $this->header[] = $headerLine;
    }

    /**
     * 写主体信息.
     */
    protected function setBody($body)
    {
        #$this->body = array_merge($this->body, $body);
        $this->body[] = http_build_query($body);
    }

    function conn($url)
    {
        $this->urlInfo = parse_url($url);
        if (!isset($this->urlInfo['port'])) {
            $this->urlInfo['port'] = 80;
        }
        $this->fh = fsockopen($this->urlInfo['host'], $this->urlInfo['port'],$this->error, $this->errmsg, 3);
    }

    function get()
    {
        $this->setLine('GET');
        $this->request();
        return $this->response;
    }

    function post($body = array())
    {
        $this->setLine("POST");
        // 设置content-type
        $this->setHeader("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
        #$this->setHeader("Cookie: smzdm_user_source=E5E02EFD9DF4A3C5681A043AC990FD09; __gads=ID=f1684ffee1d61ab5:T=1435713149:S=ALNI_MYAck61ZbFpj9noC6z0NwH8-lT3Eg; c0722eb7aab91617c651ced198759f1d4=gIEWOzc%3D; right_top_pop_describe_box=1; first_login_uid=Mbo8; first_login_uname=linzhenlong; post_permission=postpermission; PHPSESSID=i21htof1r4ikko5beugjocf8t3; c59d3b9b908e38e0e9d29bfd2761e9e95=hahQNBA%3D; smzdm_user_view=AB3D81430BE62464FE3E3CA6B946D0C3; crtg_rta=; home_cover_stuff_cookie=1; smzdm_wordpress_360d4e510beef4fe51293184b8908074=luanqibazao227%7C1437104439%7Cf8f76a20e0d042084e9af313020a5347; smzdm_wordpress_logged_in_360d4e510beef4fe51293184b8908074=luanqibazao227%7C1437104439%7Ce6cc6e6185672aea7269265b47913c4f; user-role-smzdm=subscriber; sess=NWI1YzJ8MTQzNzEwNDQzOXwzNDg0NjA0Mjc3fDgyYTEwMjY4YTk1NzEwNWExNmZiZWU2M2QxZGQ4YzRm; user=%E5%99%B6%E7%9A%84%E6%9D%A5%E5%AE%A2%7C3484604277; cfbcd63555014fa4c77bed53c21c15a88=gv95xMQ%3D; wt3_eid=%3B999768690672041%7C2143580197300617378%232143694000800594956; wt3_sid=%3B999768690672041; _gat=1; _ga=GA1.3.1108148260.1435713169; _ga=GA1.2.1108148260.1435713169; _gat=1; Hm_lvt_9b7ac3d38f30fe89ff0b8a0546904e58=1435912400,1436161523,1436756995,1436859910; Hm_lpvt_9b7ac3d38f30fe89ff0b8a0546904e58=1436941076");
        $this->setBody($body);
        // 计算长度
        $this->setHeader("Content-Length: ".strlen($this->body[0]));
        $this->setHeader("X-Requested-With: XMLHttpRequest");
        // 设置主体信息,比get多的

        $this->request();
        return $this->response;
    }

    function request()
    {
        // 把请求行,头信息,实体信息, 放在一个数组里,便于拼接
        $req = array_merge($this->line, $this->header, array(''),$this->body , array(''));
        $req = implode(self::CRLF, $req);

        // 发送请求
        fwrite($this->fh, $req);
        while (!feof($this->fh)) {
            $this->response .= fread($this->fh, 1024);
        }
        $this->close();
        return $this->response;
    }

    // 关闭连接
    function close()
    {

    }

    public function __construct($url = '')
    {
        $this->conn($url);
        $this->setHeader("Host: ".$this->urlInfo['host']);
    }
}

$url = 'http://www.smzdm.com/user/qiandao/jsonp_checkin';
$object = new Socket($url);
$object->setHeader("Cookie: smzdm_user_source=E5E02EFD9DF4A3C5681A043AC990FD09; bdshare_firstime=1435713168931; __gads=ID=f1684ffee1d61ab5:T=1435713149:S=ALNI_MYAck61ZbFpj9noC6z0NwH8-lT3Eg; c0722eb7aab91617c651ced198759f1d4=gIEWOzc%3D; right_top_pop_describe_box=1; first_login_uid=Mbo8; first_login_uname=linzhenlong; post_permission=postpermission; PHPSESSID=i21htof1r4ikko5beugjocf8t3; __jsluid=8c21742fe1bee407dae2f624b5f1549b; c59d3b9b908e38e0e9d29bfd2761e9e95=hahQNBA%3D; smzdm_user_view=AB3D81430BE62464FE3E3CA6B946D0C3; home_cover_stuff_cookie=1; cfbcd63555014fa4c77bed53c21c15a88=gv95xMQ%3D; wt3_eid=%3B999768690672041%7C2143580197300617378%232143694000800594956; wt3_sid=%3B999768690672041; _gat=1; smzdm_wordpress_360d4e510beef4fe51293184b8908074=user%3A1113155508%7C1437125911%7C16aa1a5375b1b25ca16940582b95c5d4; smzdm_wordpress_logged_in_360d4e510beef4fe51293184b8908074=user%3A1113155508%7C1437125911%7C9193ee44c66d0b6ffc2200f62f3c04f6; user-role-smzdm=subscriber; sess=MGM0NTh8MTQzNzEyNTkxMXwxMTEzMTU1NTA4fDA5M2JlYWZmMTVjZDdhZTI4MGQ4OWUxM2RmMzE4YjY3; user=%E4%BA%BA%E8%BE%BE%E5%BD%B1%E5%B0%84%7C1113155508; _ga=GA1.2.1108148260.1435713169; Hm_lvt_9b7ac3d38f30fe89ff0b8a0546904e58=1435912400,1436161523,1436756995,1436859910; Hm_lpvt_9b7ac3d38f30fe89ff0b8a0546904e58=1436953145; crtg_rta=; AJSTAT_ok_pages=13; AJSTAT_ok_times=22; amvid=e5e7962561fdc14bea84ececf611a961");
$ret = $object->get();
echo $ret;
exit;

for ($i=1;$i<=10;$i++) {
$object = new Socket($url);
    $object->setHeader("Cookie: smzdm_user_source=E5E02EFD9DF4A3C5681A043AC990FD09; __gads=ID=f1684ffee1d61ab5:T=1435713149:S=ALNI_MYAck61ZbFpj9noC6z0NwH8-lT3Eg; c0722eb7aab91617c651ced198759f1d4=gIEWOzc%3D; right_top_pop_describe_box=1; first_login_uid=Mbo8; first_login_uname=linzhenlong; post_permission=postpermission; PHPSESSID=i21htof1r4ikko5beugjocf8t3; c59d3b9b908e38e0e9d29bfd2761e9e95=hahQNBA%3D; smzdm_user_view=AB3D81430BE62464FE3E3CA6B946D0C3; crtg_rta=; home_cover_stuff_cookie=1; smzdm_wordpress_360d4e510beef4fe51293184b8908074=luanqibazao227%7C1437104439%7Cf8f76a20e0d042084e9af313020a5347; smzdm_wordpress_logged_in_360d4e510beef4fe51293184b8908074=luanqibazao227%7C1437104439%7Ce6cc6e6185672aea7269265b47913c4f; user-role-smzdm=subscriber; sess=NWI1YzJ8MTQzNzEwNDQzOXwzNDg0NjA0Mjc3fDgyYTEwMjY4YTk1NzEwNWExNmZiZWU2M2QxZGQ4YzRm; user=%E5%99%B6%E7%9A%84%E6%9D%A5%E5%AE%A2%7C3484604277; cfbcd63555014fa4c77bed53c21c15a88=gv95xMQ%3D; wt3_eid=%3B999768690672041%7C2143580197300617378%232143694000800594956; wt3_sid=%3B999768690672041; _gat=1; _ga=GA1.3.1108148260.1435713169; _ga=GA1.2.1108148260.1435713169; _gat=1; Hm_lvt_9b7ac3d38f30fe89ff0b8a0546904e58=1435912400,1436161523,1436756995,1436859910; Hm_lpvt_9b7ac3d38f30fe89ff0b8a0546904e58=1436941076");

    $post = array(
        //'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
        //'Content-Length' => 95,
        /*'pro_id'       => 'lw848l',
        'use_time'        => 1,
        'pro_score'   => 5,
        'summary_content'    => '<script>alert("xss");</script>',
        'disadvantage_content'  => '<script>alert("xss");</script>',
        'advantage_content'  => '<script>alert("xss");</script>',
        'reason_content'  => '11111111111111'.$i,
        'random' => rand(1,1000000000000),*/

        'bl_brand_name' => 111111,
        'bl_name' => '阿迪达斯Adidas Superstar Supercolor三叶草男女板鞋 多彩限量款 s31607 38',
        'bl_third' => 0,
        'bl_price' => 170,
        'bl_cate' => 999,
        'bl_cate_name' => 'post',
        'bl_brand' => 'nb',
        'bl_mall' => '奶茶家',
        'bl_url' => 'http://item.jd.hk/1950683889.html',
        'qualityStar' => 1111,
        'bl_summary' => '111111',
        'bl_good' => 'haohaohao',
        'bl_bad' => 'dasdasdasdasd',
        'bl_reason' => 'xxxx',
        'bl_tag' => 1,
        'bl_pids' => '19728,19730,19732,19734,19736',
        'bl_qx_pids' => '',
        'bl_main_pic' => 19732,
        'bl_pic_src' => 'http://img12.360buyimg.com/n1/jfs/t1501/180/5376662/112362/f8c4c977/554be640N2f4e914d.jpg',
        'bl_b2c_list' => [["http://item.jd.hk/1950683889.html","京东商城",0,710,"阿迪达斯Adidas Superstar Supercolor三叶草男女板鞋 多彩限量款 s31607 38"]]
    );
    $ret  = $object->post($post);
    echo $ret;
}