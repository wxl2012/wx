<?php

namespace handler\common;

class Account{


    /**
     * 隐藏部分字符
     *
     * @param $account
     */
    public static function hidePart($account) {
        $value = '';
        if(\handler\common\Valid::isEmail($account)){
            $prefix = substr($account, 0, 2);
            $index = strpos($account, '@');
            $suffix = substr($account, $index);
            $value = "{$prefix}****{$suffix}";
        }else if(\handler\common\Valid::isPhone($account)){
            $value = substr($account, 7);
        }

        return $value;
    }
}