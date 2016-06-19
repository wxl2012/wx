<?php
/**
 * 基于FuelPHP的微信第三方程序库
 * 
 * @package    Fuel
 * @version    1.7
 * @author     王晓雷 zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */

/**
 * 数据表结构控制器
 *
 * 主要用于实现必要公共功能
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Db extends Controller_BaseController
{

    public function before(){
        parent::before();

        if(\Fuel::$env != \Fuel::DEVELOPMENT){
            die('');
        }
    }

    public function action_index(){
        /*$tables = \DB::list_tables();
        foreach ($tables as $table){
            echo "表名:{$table}<br>";
            $columns = \DB::list_columns($table);
            foreach ($columns as $column){
                var_dump($columns);
            }
            echo "<br>###############################<br>";
        }
        die();*/
        return \Response::forge(\View::forge('dbdoc'));
    }
}
