<?php

namespace handler\common;

class Tool{

    /**
     * array转xml
     * @param $arr 待转换的数组
     * @return String 转换后的XML
     */
    public static function arrayToXml($arr) {
        $xml = '';
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= '<people>';
                $xml .= static::arrayToXml($val);
                $xml .= '</people>';
            } else if(is_numeric($val) || is_null($val)){
                $xml .= "<{$key}>{$val}</{$key}>";
            } else {
                $xml .= "<{$key}><![CDATA[{$val}]]></{$key}>";
            }
        }
        return $xml;
    }

    /**
     * 将xml转为array
     * @param $xml 待转换的XML
     * @return Array 转换后的Array
     */
    public static function xmlToArray($xml)
    {
        //将XML转为array
        $data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $arr = json_decode(json_encode($data), true);
        return $arr;
    }
}