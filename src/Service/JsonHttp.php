<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2017/9/14
 * Time: 16:45
 */

namespace Wxmp\Service;

use Interfaces\NetworkInterface;
use Uri;

class JsonHttp extends \Serializer implements NetworkInterface
{

    protected $headers = [
        "Content-Type"=>"application/json",
    ];

    /**
     * Response content.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * Basic Authorization username.
     *
     * @var string|null
     */
    protected $user;

    /**
     * Basic Authorization password.
     *
     * @var string|null
     */
    protected $password;

    /**
     * @var string
     */
    protected $url;

    protected $response;


    public function __construct($user = null, $password = null)
    {
        $this->user = $user;

        $this->password = $password;
    }

    public function request($uri, array $params = [], array $headers = [])
    {
        $this->url = $uri;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, static::USER_AGENT);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($this->headers, $headers));
        curl_setopt($ch, CURLOPT_TIMEOUT, static::TIMEOUT);
        if (!empty($this->user) && !empty($this->password)) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, sprintf('%s:%s', $this->user, $this->password));
        }
        $this->data = curl_exec($ch);
        $error = curl_error($ch);
        if (!empty($error)) {
            $this->statusCode = 504;
            $this->data = $error;
        } else {
            $this->statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }
        curl_close($ch);
        return $this;
    }

    public function patch(Uri $uri, $params = [], array $headers = [])
    {
        // TODO: Implement patch() method.
    }

    public function put(Uri $uri, $params = [], array $headers = [])
    {
        // TODO: Implement put() method.
        return $this->request($uri, $params, $headers);
    }

    public function delete(Uri $uri, $params = [], array $headers = [])
    {
        // TODO: Implement delete() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
        return $this->data;
    }

    public function get(Uri $uri, $params = [], array $headers = [])
    {
        // TODO: Implement get() method.
    }

    public function getStatusCode()
    {
        // TODO: Implement getStatusCode() method.
        return $this->statusCode;
    }

    public function isOk()
    {
        // TODO: Implement isOk() method.
        return ($this->getStatusCode() >= 200 && $this->getStatusCode() < 300) ? true : false;
    }


    public function error($callback)
    {
        // TODO: Implement error() method.
        if (!$this->isOk()) {
            $this->response = call_user_func_array($callback, [$this->toArray(), $this->getStatusCode(), $this->url]);
        }

        return $this;
    }

    public function then($callback, $error = null)
    {
        // TODO: Implement then() method.
        if ($this->isOk()) {
            $this->response = call_user_func_array($callback, [$this->toArray(), $this->getStatusCode(), $this->url]);
        } else if (null !== $error) {
            $this->response = call_user_func_array($error, [$this->toArray(), $this->getStatusCode(), $this->url]);
        }

        return $this;
    }
}