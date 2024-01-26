<?php

class Collection
{
    private array $collection;

    /**
     * Конструктор класса коллекций
     *
     * @param array $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    /** Магические методы */

    public function __invoke()
    {
        $this->print();
    }

    public function __get($name)
    {
        /** Если идет вызов свойства print -> будет вызвана функция print */
        if ($name === "print") {
            $this->print();
        }
    }

    /**
     * Возвращает нынешнюю коллекцию
     *
     * @return static
     */
    public function all(): static
    {
        return $this;
    }

    /** Функционал коллекций */

    /**
     * Возвращает кол-во элементов в коллекции
     *
     * @return int
     */
    public function count(): int
    {
        //TODO сделать проверку на вложенность через замыкание
        return count($this->collection);
    }

    /**
     * Возвращает среднее значение по коллекции
     *
     * @return integer
     */
    public function avg(): int
    {
        //TODO сделать поддержку вложенности
        return array_sum($this->collection) / count($this->collection);
    }

    /**
     * Возвращает новую коллекцию с разделением на нужное кол-во частей
     *
     * @param integer $part
     * @return Collection|bool
     */
    public function chunk(int $part): Collection|bool
    {
        if($part > count($this->collection)) return false;

        $newCollection = [];

        $offset = count($this->collection) / $part;

        $off = 0;
        for ($i = 0; $i < $offset; $i++) {
            if (!empty($newCollection))
                $off += $part;

            $newCollection[$i] = array_slice($this->collection, $off, $part);
        }

        return new Collection($newCollection);
    }

    /**
     * При наличии вложенных массивов объединяет их
     *
     * @return Collection
     */
    public function collapse(): Collection
    {
        $newCollection = [];

        foreach($this->collection as $item)
        {
            $newCollection = array_merge($newCollection, $item);
        }

        return new Collection($newCollection);
    }

    /**
     * Возвращает новую коллекцию, которая имеет ключи из нынешний коллекции 
     * с значениям, которые были переданы в функцию
     *
     * @param array $values Значения для ключей из коллекции
     * @return Collection
     */
    public function combine(array $values): Collection
    {
        if(count($this->collection) !== count($values))
            throw new Exception("Ошибка! Разные размеры коллекций");

        $newCollection = [];

        for ($i=0; $i < count($this->collection); $i++) {
            $newCollection[$this->collection[$i]] = $values[$i];
        }

        return new Collection($newCollection);
    }

    /**
     * Вывод коллекции
     *
     * @return void
     */
    public function print()
    {
        print_r($this->collection);
    }
}
