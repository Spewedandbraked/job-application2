<?php

if (!function_exists('asset')) {
    /**
     * Генерирует путь к ассету в папке public
     */
    function asset(string $path): string
    {
        $path = ltrim($path, '/');

        return '/' . $path;
    }
}

if (!function_exists('css')) {
    /**
     * Генерирует тег link для CSS
     */
    function css(string $path, array $attributes = []): string
    {
        $defaults = [
            'rel' => 'stylesheet',
            'href' => asset("css/{$path}"),
            'type' => 'text/css',
        ];

        $attrs = array_merge($defaults, $attributes);

        $html = '<link';
        foreach ($attrs as $key => $value) {
            $html .= " {$key}=\"" . htmlspecialchars($value) . "\"";
        }
        $html .= '>';

        return $html;
    }
}
