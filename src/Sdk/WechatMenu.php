<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/9/15
 * Time: 10:54
 */

namespace Wxmp\Sdk;

use Wxmp\ApiDomain;
use Wxmp\Service\JsonHttp;

class WechatMenu
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

    public function createMenu($access_token,$menu)
    {
        $uri = clone $this->uri;

        $uri->withPath("/cgi-bin/menu/create?access_token={$access_token}");

        $network = new JsonHttp();

        $result = $network->put($uri,$menu)->toArray();

        if($result['errcode']==0){
            return true;
        }else{
            throw new \Exception($result['errmsg'],$result['errcode']);
        }
    }

}