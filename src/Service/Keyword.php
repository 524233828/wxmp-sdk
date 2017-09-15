<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/9/14
 * Time: 19:08
 */

namespace Wxmp\Service;

class Keyword
{
    private $value;

    private $color;

    public function __construct($value,$color)
    {
        $this->value = $value;
        $this->color = $color;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }
}