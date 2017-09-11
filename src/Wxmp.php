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
use Wxmp\Sdk\WechatUser;
use Wxmp\Sdk\WechatWeb;

class Wxmp{

    private $wchat_base;
    private $wechat_user;
    private $wechat_web;

    public function __construct($app_id,$app_secrete,$uri="")
    {
        $this->wchat_base = new WechatBase($app_id,$app_secrete);

        $this->wechat_user = new WechatUser();

        $this->wechat_web =  new WechatWeb($app_id,$app_secrete);
    }
}