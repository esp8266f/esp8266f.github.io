<?php

class Transliteration
{
    public static function convert($to_url)
    {
        // ГОСТ 7.79-2000 Б
        $trans = array(
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'Jo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'Y',
            'Й' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'X', 'Ц' => 'C', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Shh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'Je', 'Є' => 'Je', 'Ю' => 'Ju', 'Я' => 'Ja',

            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'jo', 'ж' => 'zh', 'з' => 'z', 'и' => 'y',
            'й' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'x', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'shh', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'je', 'є' => 'je', 'ю' => 'ju', 'я' => 'ja'

        );

        $url = strtr($to_url, $trans);    // Заменяем кириллицу согласно массиву замены
        $url = strtolower($url);          // В нижний регистр

        $url = preg_replace("/[^a-z0-9]/ui", " ", $url);     // лишние символы заменяем на пробіл
        $url = preg_replace("/[\W\s]/ui", " ", $url);        // лишние символы заменяем на пробіл
        $url = preg_replace("/[\s]+/ui", "-", $url);         // Заменяем 1 и более пробелов на "-"

        return $url;
    }
}