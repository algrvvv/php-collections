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

    /**
     * Возвращает коллекцию в виде массива
     *
     * @return array
     */
    public function get(): array
    {
        return $this->collection;
    }

    /** Функционал коллекций */

    /**
     * Возвращает кол-во элементов в коллекции
     *
     * @return float|int|null
     */
    public function count(): float|int|null
    {
        $count = null;

        array_walk_recursive($this->collection, function ($item, $key) use (&$count) {
            $count++;
        });

        return $count;
    }

    /**
     * Возвращает среднее значение по коллекции
     *
     * @return float|int|null
     */
    public function avg(): float|int|null
    {
        $sum = null;
        $count = null;
        array_walk_recursive($this->collection, function ($item, $key) use (&$sum, &$count) {
            if (is_numeric($item)) {
                $count++;
                $sum += $item;
            }
        });

        return $sum / $count;
    }

    /**
     * Возвращает новую коллекцию с разделением на нужное кол-во частей
     *
     * @param integer $part
     * @return Collection|bool
     */
    public function chunk(int $part): Collection|bool
    {
        if ($part > count($this->collection)) return false;

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

        foreach ($this->collection as $item) {
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
        if (count($this->collection) !== count($values))
            throw new Exception("Ошибка! Разные размеры коллекций");

        $newCollection = [];

        for ($i = 0; $i < count($this->collection); $i++) {
            $newCollection[$this->collection[$i]] = $values[$i];
        }

        return new Collection($newCollection);
    }

    /**
     * Возвращает коллекцию, обЪединенную с массивом
     *
     * @param array $values Массив, который нужно добавить в коллекцию
     * @return Collection
     */
    public function concat(array $values): Collection
    {
        $newCollection = array_merge($this->collection, $values);
        return new Collection($newCollection);
    }

    /**
     * Функция проверяет есть ли аргумент в коллекции
     *
     * @return bool
     */
    public function contains(string|int|bool $arg): bool
    {
        $search = [];
        array_walk_recursive($this->collection, function ($item, $key) use ($arg, &$search) {
            $search[] = $arg == $item;
        });

        return in_array(true, $search);
    }

    /**
     * Функция равносильна функции `contains()`, но использует строгое сравнение
     *
     * @return bool
     */
    public function containsStrict(string|int|bool $arg): bool
    {
        $search = [];
        array_walk_recursive($this->collection, function ($item, $key) use ($arg, &$search) {
            $search[] = $arg === $item;
        });

        return in_array(true, $search);
    }

    public function diff(Collection|array $collection)
    {
        if ($collection instanceof Collection)
            $diff = array_diff($this->collection, $collection->get());
        else
            $diff = array_diff($this->collection, $collection);

        return new Collection($diff);
    }

    /**
     * Преобразует многомерную коллекцию в одноуровневую,
     * используя точечную нотацию
     *
     * @return void
     */
    public function dot()
    {
        //TODO
    }

    /**
     * Находит и возвращает дублирующиеся значения
     *
     * @param string|null $key
     * @return Collection
     */
    public function duplicates(): Collection
    {
        $values = [];
        array_walk_recursive($this->collection, function ($item, $key) use (&$values) {
            $values[$key] = $item;
        });

        $oldValues = [];
        $out = [];

        foreach ($values as $key => $value) {
            if (empty($oldValues)) {
                $oldValues[$key] = $value;
                continue;
            }

            if (in_array($value, $oldValues)) {
                $out[$key] = $value;
                continue;
            } else {
                $oldValues[$key] = $value;
            }
        }


        return new Collection($out);
    }

    /**
     * Функция перебирает каждый элемент коллекции и отправляет в функцию замыкания
     *
     * @param callable $callback
     * @return void
     */
    public function each(callable $callback)
    {
        //TODO
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
