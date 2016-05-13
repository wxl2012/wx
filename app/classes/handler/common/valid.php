<?php

namespace handler\common;

class Valid{


    /**
     * 是否是合法的手机号
     *
     * @param $phone    手机号码
     * @return bool     合法返回True,否则返回False
     */
    public static function isPhone($phone){
        if (strlen ( $phone ) != 11 || ! preg_match ( '/^1[3|4|5|7|8][0-9]\d{4,8}$/', $phone )) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 是否是合法的邮箱
     *
     * @param $value    邮箱地址
     * @return mixed    是返回True,否则返回False
     */
    public static function isEmail($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}