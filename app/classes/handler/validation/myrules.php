<?php
namespace handler\validation;

class MyRules
{
    public static function _validation_unique($val, $options)
    {
        \Validation::active()->set_message('unique', ":label已存在");

        list($table, $field) = explode('.', $options);
        $result = \DB::select(\DB::expr('count(*) as count'))
            ->where($field, '=', $val)
            ->from($table)
            ->execute()
            ->as_array();

        return ($result[0]['count'] == 0);
    }

    public static function _validation_exists($val, $options)
    {
        \Validation::active()->set_message('exists', ":Label不存在");

        list($table, $field) = explode('.', $options);
        $result = \DB::select(\DB::expr('count(*) as count'))
            ->where($field, '=', $val)
            ->from($table)
            ->execute()
            ->as_array();

        return ($result[0]['count'] == 0);
    }

    public static function _validation_valid_date($val)
    {
        \Validation::active()->set_message('valid_date', "无效的日期");
        if ($val === '') return true;
        return strtotime($val) > 0;
    }
// public static function _validation_access_allow($val, $location)
// {
//     $result = DB::select("id")->where('id', '=', $val)->from('users')->execute();

//     if($result->count() == 0)
//         return false;

//     if (Auth::has_access($controller))
// }

}
