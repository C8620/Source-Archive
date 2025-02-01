<?php
/* 
 * i18n.php
 * 
 * This file loads the target language file and provides a function to translate
 * strings in English.
 * 
 * This file is part of the GCGSRC project.
 *  
 */

$i18n_lang = "zz";
$i18n_translations = array();

function i18n_init ($lang){
    global $i18n_lang;
    global $i18n_translations;
    if($lang != $i18n_lang){
        $i18n_lang = $lang;
        $i18n_translations = json_decode(file_get_contents(str_replace("{LANGUAGE}", $i18n_lang, dirname(__FILE__) . "/i18n/{LANGUAGE}.json")), true);
    }
}

function __ ($string, $args = array()){
    global $i18n_translations;
    if (isset($i18n_translations[$string])){
        $string = $i18n_translations[$string];
    }
    if (count($args) > 0){
        foreach ($args as $key => $value){
            $string = str_replace("{" . $key . "}", $value, $string);
        }
    }
    return $string;
}


function __e ($string, $args = array()){
    echo __($string, $args);
}

function i18n_local_name ($lang){
    switch ($lang){
        case "zh":
            return "简体中文";
        case "zht":
            return "繁體中文";
        case "en":
            return "English";
        case "ja":
            return "日本語";
        case "kr":
            return "한국어";
        default:
            return "Unknown";
    }
}

function i18n_fallback_lang ($lang){
    switch ($lang){
        case "zht":
            return "zh";
        case "en":
            return "zh";
        case "ja":
            return "en";
        default:
            return "en";
    }
}