<?php
/**
 * Created by PhpStorm.
 * User: JoseChan
 * Date: 2017/9/12 0012
 * Time: 下午 8:10
 */


namespace Wxmp\Sdk;

use Wxmp\ApiDomain;

class WechatTemplate
{

    /**
     * @var \Network\Http
     */
    private $network;
    /**
     * @var \Uri
     */
    private $uri;

    public function __construct($uri = "")
    {
        $this->network = new \Network\Http();

        $uri = empty($uri) ? ApiDomain::GENERATE_DOMAIN : $uri;

        $this->uri = new \Uri("https://" . $uri);
    }

    public function send($access_token,$data)
    {
        $uri = clone $this->uri;

        $uri->withPath("/cgi-bin/message/template/send?access_token={$access_token}");

//        $data = [
//            "appid" => $this->app_id,
//            "secret" => $this->app_secret,
//            "code" => $code,
//            "grant_type" => 'authorization_code'
//        ];

        $result = $this->network->put($uri, $data)->toArray();

        if(isset($result['msgid']))
        {
            return $result;
        }else{
            throw new \Exception($result['errmsg'],$result['errcode']);
        }
    }

}
