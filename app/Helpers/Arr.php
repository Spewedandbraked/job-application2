<?php

namespace App\Helpers;

class Arr
{
    /**
     * Рекурсивный поиск в многомерном массиве
     * 
     * @param array $array Многомерный массив для поиска
     * @param string $searchField Поле, в котором осуществляется поиск
     * @param string $recursiveKey Ключ для рекурсивного обхода
     * @param mixed $searchable Значение для поиска
     * @param bool $strict Использовать строгое сравнение
     * @return array|null Найденный элемент массива или null если не найден
     */
    public static function recursiveSearch(
        array $array,
        string $searchField,
        string $recursiveKey,
        mixed $searchable,
        bool $strict = false
    ): ?array {
        foreach ($array as $item) {
            // Проверка наличия $searchable в искомом
            if (isset($item[$searchField])) {
                if (
                    ($strict && $item[$searchField] === $searchable)
                    || (!$strict && $item[$searchField] == $searchable)
                ) {
                    return $item;
                }
            }

            // Поиск внутри вложенных элементов
            if (isset($item[$recursiveKey]) && is_array($item[$recursiveKey])) {
                $result = self::recursiveSearch(
                    $item[$recursiveKey],
                    $searchField,
                    $recursiveKey,
                    $searchable,
                    $strict
                );

                if ($result !== null) {
                    return $result;
                }
            }
        }

        return null;
    }
}
