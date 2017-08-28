<?php
/**
 * Created by PhpStorm.
 * User: JoseChan
 * Date: 2017/8/28 0028
 * Time: 下午 12:08
 */

namespace Wxmp\Sdk;

use Wxmp\ApiDomain;

class WechatUser
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

        $uri = empty($uri)?ApiDomain::GENERATE_DOMAIN:$uri;

        $this->uri = new \Uri("https://".$uri);
    }

    public function getUserInfo($access_token,$open_id,$lang = "zh_CN")
    {
        $uri = clone $this->uri;

        $uri->withPath("/cgi-bin/user/info");

        $data = [
            "access_token"=>$access_token,
            "open_id"=>$open_id,
            "lang"=>$lang
        ];

        $result = $this->network->get($uri,$data)->toArray();

        if(isset($result['subscribe'])){
            return $result;
        }else{
            throw new \Exception($result['errmsg'],$result['errcode']);
        }
    }
}