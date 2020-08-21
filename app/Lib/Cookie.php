<?php

namespace App;

use yii\base\BaseObject;
use yii\web\CookieCollection;

class Cookie extends BaseObject
{
    const LANGUAGE = 'language';

    /** @var  CookieCollection */
    private $cookieRequest;

    /** @var  CookieCollection */
    private $cookieResponse;

    /**
     * @param CookieCollection $cookieRequest
     */
    public function setCookieRequest($cookieRequest)
    {
        $this->cookieRequest = $cookieRequest;
    }

    /**
     * @param CookieCollection $cookieResponse
     */
    public function setCookieResponse($cookieResponse)
    {
        $this->cookieResponse = $cookieResponse;
    }

    /**
     * @param      $name
     * @param null $default_value
     * @return mixed
     */
    public function get($name, $default_value = null)
    {
        return $this->cookieRequest->getValue($name, $default_value);
    }

    /**
     * @param null $needle
     * @return array
     */
    public function getArray($needle = null)
    {
        $result       = [];
        $cookie_array = $this->cookieRequest->toArray();

        foreach ($cookie_array as $cookie_name => $cookie_value) {
            if (!$needle || ($needle && preg_match('/' . $needle . '/', $cookie_name))) {
                $result[$cookie_name] = $cookie_value;
            }
        }

        return $result;
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return $this->cookieRequest->has($name);
    }

    /**
     * @param        $name
     * @param        $value
     * @param int    $expire
     * @param string $path
     * @param bool   $http_only
     * @param string $domain
     * @param bool   $secure
     */
    public function set($name, $value, $expire = 0, $path = '/', $http_only = true, $domain = '', $secure = false)
    {
        $cookie           = new \yii\web\Cookie();
        $cookie->name     = $name;
        $cookie->value    = $value;
        $cookie->expire   = $expire;
        $cookie->path     = $path;
        $cookie->httpOnly = $http_only;
        $cookie->domain   = $domain;
        $cookie->secure   = $secure;
        $this->cookieResponse->add($cookie);
    }

    /**
     * @param string $name имя кук к удалению
     */
    public function delete($name)
    {
        $this->cookieRequest->remove($name);
    }

    public function clear()
    {
        $this->cookieRequest->removeAll();
    }

    public function deleteResponse($name)
    {
        $this->cookieResponse->remove($name);
    }

}