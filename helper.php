<?php

require "./Collection.php";

if (!function_exists('collect')) {

    /**
     * Создание новой коллекции
     *
     * @param array $array Массив, который нужно преобразовать в коллекцию
     * @return Collection
     */
    function collect(array $array): Collection
    {
        return new Collection($array);
    }
}
