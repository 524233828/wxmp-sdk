<?php
/**
 * Created by PhpStorm.
 * User: JoseChan
 * Date: 2017/8/4 0004
 * Time: 下午 2:24
 */

namespace Wxmp\Sdk;

use Wxmp\ApiDomain;

class WechatBase
{
    private $app_id;
    private $app_secret;
    private $network;
    private $uri;
    private $redis;

    public function __construct($app_id,$app_secret,$uri = "")
    {
        $this->network = new \Network\Http();

        $uri = empty($uri)?ApiDomain::GENERATE_DOMAIN:$uri;

        $this->uri = new \Uri("https://".$uri);

        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }

    public function getAccessToken()
    {
//        if(ex)
    }

    public function bindRedis(\Redis $redis)
    {
        $this->redis = $redis;
        return $this;
    }

    public function testAccessToken()
    {

    }

}