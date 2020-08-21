<?php

namespace App\Helpers;


class Url extends \yii\helpers\Url
{
    /**
     * Валиден ли урл
     * @param $url
     * @return mixed
     */
    public static function isValid($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED) !== false;
    }

    /**
     * Подготовить URL, если у него нету схемы
     * @param $url
     * @return string
     */
    public static function makeValid($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }

        return $url;
    }

    /**
     * @param $url
     *
     * @return array
     */
    public static function getUrlParams($url) {
        $url_params = [];
        parse_str(parse_url($url, PHP_URL_QUERY), $url_params);
        return $url_params;
    }

    /**
     * @see out
     * @param $url
     * @return mixed
     */
    public static function getHost($url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        return preg_replace('/^www\./', '', $host);
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    public static function getPath($url)
    {
        return parse_url($url, PHP_URL_PATH);
    }

    /**
     * @param $domain
     * @param $path
     * @return string
     */
    public static function concatDomainPath($domain, $path)
    {
        if (mb_substr($domain, -1, null, 'UTF-8') == '/') {
            $domain = mb_substr($domain, 0, -1, 'UTF-8');
        }
        if (mb_substr($path, 0, 1, 'UTF-8') == '/') {
            $path = mb_substr($path, 1, null, 'UTF-8');
        }
        return $domain . '/' . $path;
    }

    /**
     * Получение домена второго уровня из URL'а www.sasdf.fdfdf.ru => fdfdf.ru
     * @param string $url URL сайта
     * @return bool|string
     */
    public static function getDomain($url) {
        $host = self::getHost($url);
        if (!$host) {
            return false;
        }
        $url = explode('.', $host);
        return implode('.', array_slice($url, sizeof($url) - 2, 2));
    }

    /**
     * получаем URL без schema
     * @param $url
     * @return string
     */
    public static function getUrlWithoutScheme($url) {
        return preg_replace('(^https?:)', '', $url);
    }
}