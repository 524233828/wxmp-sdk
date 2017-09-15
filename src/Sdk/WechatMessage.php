<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/9/15
 * Time: 10:16
 */

namespace Wxmp\Sdk;

use Wxmp\ApiDomain;
use Wxmp\Service\JsonHttp;

class WechatMessage
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

    public function customSend($access_token, $open_id, $type = "text", $data = [])
    {
        $uri = clone $this->uri;

        $uri->withPath("/cgi-bin/message/custom/send?access_token={$access_token}");

        $data = [
            "touser" => $open_id,
            "msgtyp" => $type,
            $type =>  $data,
        ];

        $json_http = new JsonHttp();

        $result = $json_http->put($uri, $data)->toArray();

        if(isset($result['msgid']))
        {
            return $result;
        }else{
            throw new \Exception($result['errmsg'],$result['errcode']);
        }
    }
}