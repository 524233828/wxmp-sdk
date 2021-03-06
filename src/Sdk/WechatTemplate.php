<?php
/**
 * Created by PhpStorm.
 * User: JoseChan
 * Date: 2017/9/12 0012
 * Time: 下午 8:10
 */


namespace Wxmp\Sdk;

use Wxmp\ApiDomain;
use Wxmp\Service\JsonHttp;
use Wxmp\Service\Template;

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

    public function send($access_token,$open_id,Template $template,$url = "",$miniprogram = [])
    {
        $uri = clone $this->uri;

        $uri->withPath("/cgi-bin/message/template/send?access_token={$access_token}");

        $data = [
            "touser" => $open_id,
            "template_id" => $template->getTemplateId(),
            "data" => $template->getData()
        ];

        if(!empty($url))
        {
            $data['url'] = $url;
        }

        if(!empty($miniprogram))
        {
            $data['miniprogram'] = $miniprogram;
        }

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
