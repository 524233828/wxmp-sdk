<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/9/11
 * Time: 9:47
 */

namespace Wxmp;

use Wxmp\ApiDomain;
use Wxmp\Sdk\WechatBase;
use Wxmp\Sdk\WechatMenu;
use Wxmp\Sdk\WechatMessage;
use Wxmp\Sdk\WechatTemplate;
use Wxmp\Sdk\WechatUser;
use Wxmp\Sdk\WechatWeb;

class Wxmp{

    public $wchat_base;
    public $wechat_user;
    public $wechat_web;
    public $wechat_template;
    public $wechat_menu;
    public $wechat_message;

    public function __construct($app_id,$app_secrete,$uri="")
    {
        $this->wchat_base = new WechatBase($app_id,$app_secrete);

        $this->wechat_user = new WechatUser();

        $this->wechat_web =  new WechatWeb($app_id,$app_secrete);

        $this->wechat_template = new WechatTemplate();

        $this->wechat_menu = new WechatMenu();

        $this->wechat_message = new WechatMessage();
    }
}