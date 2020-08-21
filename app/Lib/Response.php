<?php

namespace App;

use yii\base\BaseObject;
use yii\web\HttpException;

class Response extends BaseObject
{
    const AJAX_STATUS_SUCCESS = 'success';
    const AJAX_STATUS_FAIL = 'fail';

    /** @var \yii\console\Response|\yii\web\Response */
    private $response;

    /**
     * @param \yii\console\Response|\yii\web\Request Response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @param string $message
     *
     * @throws HttpException
     */
    public function set404($message = 'Not found')
    {
        throw new HttpException(404, $message);
    }

    /**
     * @param string $message
     *
     * @throws HttpException
     */
    public function set403($message = '')
    {
        throw new HttpException(403, $message);
    }

    public function setJsonFormat()
    {
        $this->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function setRawFormat()
    {
        $this->response->format = \yii\web\Response::FORMAT_RAW;
    }

    public function setXmlFormat($data = null)
    {
        $this->response->format = \yii\web\Response::FORMAT_XML;
        if ($data) {
            if (is_array($data)) {
                $this->response->data = $data;
            } else {
                $this->response->content = $data;
            }
        }
    }

    public function setXmlRootTag($tag_name)
    {
        $this->response->formatters[\yii\web\Response::FORMAT_XML]['rootTag'] = $tag_name;
    }

    public function setHtmlFormat()
    {
        $this->response->format = \yii\web\Response::FORMAT_HTML;
    }

    public function redirect($url, $statusCode = 302, $checkAjax = true)
    {
        return $this->response->redirect($url, $statusCode, $checkAjax);
    }

    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    /**
     * @param $content
     * @param $attachmentName
     * @param array $options
     * @return \yii\web\Response
     * @throws \yii\web\RangeNotSatisfiableHttpException
     */
    public function sendContentAsFile($content, $attachmentName, $options = [])
    {
        return $this->response->sendContentAsFile($content, $attachmentName, $options);
    }

    /**
     * @param $handle
     * @param $attachmentName
     * @param array $options
     * @return \yii\web\Response
     * @throws \yii\web\RangeNotSatisfiableHttpException
     */
    public function sendStreamAsFile($handle,$attachmentName, $options = [])
    {
        return $this->response->sendStreamAsFile($handle,$attachmentName, $options);
    }
}