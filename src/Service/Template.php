<?php
/**
 * Created by PhpStorm.
 * User: JoseChan
 * Date: 2017/9/12 0012
 * Time: 下午 8:16
 *
 * 模板消息模板类
 */

namespace Wxmp\Service;

use function PHPSTORM_META\type;
use Prophecy\Exception\Exception;

class Template
{
    protected $template_id;

    protected $data = [];

    protected $keyword_list = [];

    public function __construct($template_id, $data = [], $keyword_list = [])
    {
        $this->template_id = $template_id;
        $this->data = $data;
        $this->keyword_list = $keyword_list;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.

        if(!in_array($name,$this->keyword_list))
        {
            throw new \Exception("no such keyword");
        }
        $keyword = $arguments[0];

        if(!($keyword instanceof Keyword))
        {
            throw new \Exception("need a argument of Keyword,others given");
        }

        $this->data[$name]=[
            "value"=>$keyword->getValue(),
            "color"=>$keyword->getColor()
        ];

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTemplateId()
    {
        return $this->template_id;
    }

}