<?php

namespace App;

use yii\base\BaseObject;

class Request extends BaseObject
{
    const METHOD_GET     = 1;
    const METHOD_POST    = 2;

    /** @var \yii\console\Request|\yii\web\Request */
    private $request;

    /**
     * @param \yii\console\Request|\yii\web\Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return bool|mixed
     * @throws \Exception
     */
    public function isGet()
    {
        return $this->request->isGet;
    }

    /**
     * @return bool|mixed
     * @throws \Exception
     */
    public function isPost()
    {
        return $this->request->isPost;
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return $this->request->isAjax;
    }

    /**
     * @return string
     */
    public function getCsrfParam()
    {
        return $this->request->csrfParam;
    }

    /**
     * @return string
     */
    public function getCsrf()
    {
        return $this->request->getCsrfToken();
    }

    /**
     * @param      $key
     * @param null $default_value
     * @param null $max_value
     * @return int|null
     */
    public function getInt($key, $default_value = null, $max_value = null)
    {
        return $this->getParamInt($key, self::METHOD_GET, $default_value, $max_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     * @return mixed|null
     */
    public function getStr($key, $default_value = null)
    {
        return $this->getParamStr($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     * @return mixed|null
     */
    public function postStr($key, $default_value = null)
    {
        return $this->getParamStr($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param string     $key
     * @param int        $source
     * @param mixed|null $default_value
     * @param null|int   $max_value максимальное значение
     * @return int|null
     */
    protected function getParamInt($key, $source = self::METHOD_GET, $default_value = null, $max_value = null)
    {
        $value = $this->getParam($key, $source);
        if (!is_numeric($value)) {
            return $default_value;
        }
        $value_int = (int)$this->getParam($key, $source);

        if (is_numeric($max_value) && $value_int > $max_value) {
            return $max_value;
        }

        return $value_int;
    }

    /**
     * @param string         $key
     * @param array|int|null $source
     * @param mixed|null     $default_value
     * @return mixed|null
     */
    protected function getParamStr($key, $source = self::METHOD_GET, $default_value = null)
    {
        $value = $this->getParam($key, $source);
        if (!is_string($value)) {
            return $default_value;
        }

        return $value;
    }

    /**
     * @param string     $key
     * @param int        $source
     * @param mixed|null $default_value
     * @return mixed|null
     */
    protected function getParam($key, $source = self::METHOD_GET, $default_value = null)
    {
        if ($source == self::METHOD_GET) {
            return $this->get($key, $default_value);
        }

        return $this->post($key, $default_value);
    }

    public function get($key = null, $default_value = null)
    {
        return $this->request->get($key, $default_value);
    }

    public function post($key = null, $default_value = null)
    {
        return $this->request->post($key, $default_value);
    }

    /**
     * @param       $key
     * @param int   $source
     * @param array $default_value
     * @return array|mixed|null
     */
    protected function getParamArray($key, $source = self::METHOD_GET, array $default_value = [])
    {
        $value = $this->getParam($key, $source);
        if (!is_array($value)) {
            return $default_value;
        }

        return $value;
    }

    /**
     * @param       $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function getArray($key, array $default_value = [])
    {
        return $this->getParamArray($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param      $key
     * @param null $default_value
     * @param null $max_value
     * @return int|null
     */
    public function postInt($key, $default_value = null, $max_value = null)
    {
        return $this->getParamInt($key, self::METHOD_POST, $default_value, $max_value);
    }

    /**
     * @param       $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function postArray($key, array $default_value = [])
    {
        return $this->getParamArray($key, self::METHOD_POST, $default_value);
    }

}
