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
    /**
     * @var \Network\Http
     */
    private $network;
    /**
     * @var \Uri
     */
    private $uri;
    /**
     * @var \Redis
     */
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
        if(!($this->redis instanceof \Redis))
        {
            throw new \Exception("require Redis Object,please use bindRedis");
        }

        $key = "wxmp:{$this->app_id}:access_token";
        if($access_token = $this->redis->get($key))
        {
            if($this->testAccessToken($access_token)){
                return $access_token;
            }
        }

        $uri = clone $this->uri;
        $uri->withPath("/cgi-bin/token");

        $data = [
            "grant_type"=>"client_credential",
            "appid"=>$this->app_id,
            "secret"=>$this->app_secret
        ];

        $result = $this->network->get($uri,$data)->toArray();

        $this->redis->set($key,$result['access_token'],$result['expire_in']);

        return $result['access_token'];
    }

    public function bindRedis(\Redis $redis)
    {
        $this->redis = $redis;
        return $this;
    }

    public function testAccessToken($access_token)
    {
        return true;
    }

}