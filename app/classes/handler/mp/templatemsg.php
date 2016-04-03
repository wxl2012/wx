<?php

/**
 * 基于FuelPHP的微信第三方程序库
 *
 * @package    Fuel
 * @version    1.7
 * @author     Ray zyr.wxl@gmail.com
 * @license    MIT License
 * @copyright  2015 PMonkey Team
 * @link       http://mnzone.cn
 */

/**
 * 处理微信模板消息
 *
 * @package  app
 * @extends  Controller
 */
namespace handler\mp;

class TemplateMsg {

    private $domain = 'https://api.weixin.qq.com';
    private $account = false;
    private $url;
    private $to;
    private $template_id;

    function __construct($account, $to, $tmpid, $url = '')
    {
        $this->account = $account;
        $this->to = $to;
        $this->template_id = $tmpid;
        $this->url = $url;
    }

    /**
     * 发送模板消息
     *
     * $data = [
     *      'first' => [
     *          'value' => '',
     *          'color' => '',
     *      ],
     *      'keynote1' => [
     *          'value' => '',
     *          'color': => '',
     *      ],
     *      'remark' => [
     *          'value' => '',
     *          'color' => ''
     *      ]
     * ]
     *
     * @param $data 模板数据
     * @return mixed 返回发送结果
     */
    public function send($data){
        $params = [
            'touser' => $this->to,
            'template_id' => $this->template_id,
            'url' => $this->url,
            'data' => $data
        ];

        if($this->account->temp_token_valid < time()){
            $result = \handler\mp\Tool::generate_token($this->account->app_id, $this->account->app_secret);
            $this->account->temp_token = $result['token'];
            $this->account->temp_token_valid = $result['valid'];
            $this->account->save();
        }

        $url = "{$this->domain}/cgi-bin/message/template/send?access_token={$this->account->temp_token}";
        $result = \handler\common\UrlTool::request($url, 'POST', json_encode($params), true);

        return json_decode($result);
    }
}