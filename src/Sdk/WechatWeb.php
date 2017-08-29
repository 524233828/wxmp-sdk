<?php
/**
 * Created by PhpStorm.
 * User: JoseChan
 * Date: 2017/8/28 0028
 * Time: 下午 2:40
 */


namespace Wxmp\Sdk;

use Wxmp\ApiDomain;

class WechatWeb
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

    public function __construct($app_id,$app_secret,$uri = "")
    {
        $this->network = new \Network\Http();

        $uri = empty($uri)?ApiDomain::GENERATE_DOMAIN:$uri;

        $this->uri = new \Uri("https://".$uri);

        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }

    public function getAccessToken($code)
    {
        $uri = clone $this->uri;

        $uri->withPath("/sns/oauth2/access_token");

        $data = [
            "appid"=>$this->app_id,
            "secret"=>$this->app_secret,
            "code"=>$code,
            "grant_type"=>'authorization_code'
        ];

        $result = $this->network->get($uri,$data)->toArray();

        if(isset($result['openid'])){
            return $result;
        }else{
            throw new \Exception($result['errmsg'],$result['errcode']);
        }
    }

    public function getUserInfo($access_token,$open_id,$lang="zh_CN")
    {
        $uri = clone $this->uri;

        $uri->withPath("/sns/userinfo");

        $data = [
            "access_token"=>$access_token,
            "openid"=>$open_id,
            "lang"=>$lang
        ];

        $result = $this->network->get($uri,$data)->toArray();

        if(isset($result['openid'])){
            return $result;
        }else{
            throw new \Exception($result['errmsg'],$result['errcode']);
        }
    }
}