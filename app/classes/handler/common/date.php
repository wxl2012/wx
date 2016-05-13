<?php

namespace handler\common;

class Date{


    /**
     * 获取指定日期是星期几
     *
     * @param $date     日期
     * @return mixed    星期几
     */
    public static function getWeek($date) {
        $weeks = ['SUN' => '周日', 'MON' => '周一', 'TUE' => '周二', 'WED' => '周三', 'THU' => '周四', 'FRI' => '周五', 'SAT' => '周六'];
        return $weeks[strtoupper(date('D', $date))];
    }
}