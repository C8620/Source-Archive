<?php

function getRandomName($language)
{
    // Names file (in json), located in i18n/names_(lang).json
    $filename = '../inc/i18n/names_' . $language . '.json';
    if (!file_exists($filename)) {
        return $_SERVER['REMOTE_ADDR'];
    } else {
        $namesConfig = json_decode(file_get_contents($filename), true);
        if (!isset($namesConfig['first']) || !isset($namesConfig['second']) ||
            !is_array($namesConfig['first']) || !is_array($namesConfig['second']) || 
            count($namesConfig['first']) == 0 || count($namesConfig['second']) == 0 ||
            !isset($namesConfig['connector']) || !is_string($namesConfig['connector'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            $first = $namesConfig['first'];
            $second = $namesConfig['second'];
            $connector = $namesConfig['connector'];
            $randomName = $first[array_rand($first)] . $connector . $second[array_rand($second)];
            return $randomName;
        }
    }
}