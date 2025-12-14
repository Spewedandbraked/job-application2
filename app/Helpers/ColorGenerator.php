<?php

namespace App\Helpers;

class ColorGenerator
{
    private static $colors = [
        'A' => '9CFF9C', // Светло-зеленый
        'F' => 'FF9C9C', // Светло-красный
        'B' => '9C9CFF', // Светло-синий
        'C' => 'FFFF9C', // Светло-желтый
        'D' => '9CFFFF', // Светло-голубой
        'E' => 'FF9CFF', // Светло-розовый
    ];
    public static function generateRandomColor($index)
    {
        // Генерируем трехбуквенный код на основе индекса
        $codes = ['A', 'F', 'B', 'C', 'D', 'E'];
        $totalCodes = count($codes);

        $first = $codes[$index % $totalCodes];
        $second = $codes[(floor($index / $totalCodes)) % $totalCodes];
        $third = $codes[(floor($index / ($totalCodes * $totalCodes))) % $totalCodes];

        // Преобразуем буквы в составляющие RGB
        $colorMap = [
            'A' => [0x9C, 0xFF, 0x9C], // R=9C, G=FF, B=9C
            'F' => [0xFF, 0x9C, 0x9C], // R=FF, G=9C, B=9C
            'B' => [0x9C, 0x9C, 0xFF], // R=9C, G=9C, B=FF
            'C' => [0xFF, 0xFF, 0x9C], // R=FF, G=FF, B=9C
            'D' => [0x9C, 0xFF, 0xFF], // R=9C, G=FF, B=FF
            'E' => [0xFF, 0x9C, 0xFF], // R=FF, G=9C, B=FF
        ];

        // Смешиваем цвета
        $r = intval(($colorMap[$first][0] + $colorMap[$second][0] + $colorMap[$third][0]) / 3);
        $g = intval(($colorMap[$first][1] + $colorMap[$second][1] + $colorMap[$third][1]) / 3);
        $b = intval(($colorMap[$first][2] + $colorMap[$second][2] + $colorMap[$third][2]) / 3);

        // Преобразуем в HEX
        return sprintf("%02X%02X%02X", $r, $g, $b);
    }

    // Альтернативный простой способ - градиент от зеленого к красному
    public static function generateGradientColor($index, $total)
    {
        if ($total <= 1) {
            $ratio = 0;
        } else {
            $ratio = $index / ($total - 1);
        }

        // От зеленого (0, 255, 0) к красному (255, 0, 0)
        $red = (int)(255 * $ratio);
        $green = (int)(255 * (1 - $ratio));
        $blue = 100; // Немного синего, потому что моя фамилия - Синенко

        return sprintf("%02X%02X%02X", $red, $green, $blue);
    }


    public static function generateColor($index)
    {
        // Генерируем трехбуквенный код на основе индекса
        $codes = ['A', 'F', 'B', 'C', 'D', 'E'];
        $totalCodes = count($codes);

        $first = $codes[($index) % $totalCodes];
        $second = $codes[(floor($index / $totalCodes)) % $totalCodes];
        $third = $codes[(floor($index / ($totalCodes * $totalCodes))) % $totalCodes];

        return [self::$colors[$first], self::$colors[$second], self::$colors[$third]][rand(0, 2)];
    }
}
