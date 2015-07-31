<?php
/**
 * Created by linzl
 * User: linzl<linzhenlong@smzdm.com>
 * Date: 15/7/29
 * Time: 上午9:56
 */

header("Content-type:text/xml");
$data_array = array(
    array(
        'title' => 'title1',
        'content' => 'content1',
        'pubdate' => '2009-10-11',
    ),
    array(
        'title' => 'title2',
        'content' => 'content2',
        'pubdate' => '2009-11-11',
    )
);

//  属性数组
$attribute_array = array(
    'title' => array(
        'size' => 1
    )
);

$dom = new DOMDocument("1.0", "utf-8");

$article = $dom->createElement('root');
$dom->appendChild($article);

foreach ($data_array as $data) {
    $item = $dom->createElement('item');
    $article->appendchild($item);

    create_item($dom, $item, $data, $attribute_array);
}

echo $dom->saveXML();

function create_item($dom, $item, $data, $attribute) {
    if (is_array($data)) {
        foreach ($data as $key => $val) {
            //  创建元素
            $$key = $dom->createElement($key);
            $item->appendchild($$key);

            //  创建元素值
            $text = $dom->createTextNode($val);
            $$key->appendchild($text);

            if (isset($attribute[$key])) {
                //  如果此字段存在相关属性需要设置
                foreach ($attribute[$key] as $akey => $row) {
                    //  创建属性节点
                    $$akey = $dom->createAttribute($akey);
                    $$key->appendchild($$akey);

                    // 创建属性值节点
                    $aval = $dom->createTextNode($row);
                    $$akey->appendChild($aval);
                }
            }   //  end if
        }
    }   //  end if
}   //  end function