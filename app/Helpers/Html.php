<?php

namespace App\Helpers;

class Html
{
    public static function isHtmlStructureValid($tags): bool
    {
        $xmlString = '<root>' . implode("\n", $tags) . '</root>';

        libxml_use_internal_errors(true);
        libxml_clear_errors();

        $result = simplexml_load_string($xmlString);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        return $result !== false && empty($errors);
    }
}
