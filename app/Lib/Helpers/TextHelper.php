<?php
/**
 *  Класс для обработки строковых значений
 */
namespace App\Helpers;


class TextHelper
{
    public static function upperFirstChar($string)
    {
        $firstChar = mb_convert_case(mb_substr($string, 0, 1), MB_CASE_UPPER);

        return $firstChar . mb_substr($string, 1);
    }
}