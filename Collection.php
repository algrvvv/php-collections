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
        return $this->collection[$name] ?? null;
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
    public function toArray(): array
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

    /**
     * Метод сравнивает коллекцию с другой коллекцией или массивом и возвращает новую коллекцию
     * из исходных значений, которых нет в переданной коллекции или массиве
     *
     * @param Collection|array $collection
     * @return Collection
     */
    public function diff(Collection|array $collection): Collection
    {
        if ($collection instanceof Collection)
            $diff = array_diff($this->collection, $collection->toArray());
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
     * @return Collection
     */
    public function each(callable $callback)
    {
        $out = [];
        foreach ($this->collection as $key => $value) {
            $result = call_user_func($callback, $value, $key);
            if ($result === false) break;
            $out[] = $result;
        }

        return new Collection($out);
    }

    /**
     * Возвращает коллекцию, в которой не будет значений по полученным в функцию
     * ключам
     *
     * @param array|string $except Ключи, который не будут возвращены
     * @return Collection
     */
    public function except(array|string $except): Collection
    {
        $out = [];
        foreach ($this->collection as $key => $value) {
            if (in_array($key, (array)$except)) continue;

            $out[$key] = $value;
        }

        return empty($out) ? $this->toArray() : new Collection($out);
    }

    /**
     * Возвращает коллекцию элементов с указанными ключами
     *
     * @param array|string $only
     * @return Collection
     */
    public function only(array|string $only): Collection
    {
        $out = [];
        foreach ($this->collection as $key => $value) {
            if (in_array($key, (array) $only)) $out[$key] = $value;
        }

        return new Collection($out);
    }

    /**
     * Возвращает новую коллекцию отфильтрованную по условию в обратном вызове,
     * который передается в функцию
     *
     * @param callable $callback Функция фильтрации
     * @return Collection
     */
    public function filter(callable $callback): Collection
    {
        $out = [];
        foreach ($this->collection as $key => $value) {
            $res = call_user_func($callback, $value, $key);
            if ($res) $out[$key] = $value;
        }

        return new Collection($out);
    }

    /**
     * Возвращает просто первый элемент, если не задана функция для поиска.
     * Если передана функция, то вернется первый элемент, который удовлетворяет
     * условие в этой функции
     *
     * @param callable|null $callback
     * @return mixed
     */
    public function first(callable $callback = null): mixed
    {
        if (is_null($callback))
            return array_shift($this->collection);

        $out = null;
        foreach ($this->collection as $key => $value) {
            $res = call_user_func($callback, $value, $key);
            if ($res) {
                $out = $value;
                break;
            }
        }

        return $out;
    }

    /**
     * Возвращает последний элемент коллекции
     *
     * @return mixed
     */
    public function last(): mixed
    {
        //TODO добавить коллбек
        return array_pop($this->collection);
    }

    /**
     * Возвращает новую коллекцию, в которой ключи и значения меняются местами
     *
     * @return Collection
     */
    public function flip(): Collection
    {
        $out = [];

        foreach ($this->collection as $key => $value) {
            $out[$value] = $key;
        }

        return new Collection($out);
    }

    /**
     * Возвращает коллекцию, в которой будет удален элемент по заданному ключу
     *
     * @param mixed $key Ключ, по которому нужно удалить элемент
     * @return Collection
     */
    public function forget(mixed $key): Collection
    {
        $out = $this->collection;
        if (isset($out[$key])) {
            unset($out[$key]);
        }

        return new Collection($out);
    }

    /**
     * Функция возвращает элемент по заданному ключу
     *
     * @param string $key Ключ по которому должен воспроизводиться поиск
     * @param mixed $defaultValue Дефолтное значение, если элемент по ключу не найден
     * @return mixed
     */
    public function get(string $key, mixed $defaultValue = null): mixed
    {
        return $this->collection[$key] ?? $defaultValue;
    }

    /**
     * Группирует элементы коллекции по заданному ключу
     *
     * @return void
     */
    public function groupBy(mixed $sort)
    {
        //TODO
        function array_recursive(mixed $data, $sort)
        {
            // static $out = [];
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $data[$key] = array_recursive($value, $sort);
                }

                return $data;
            }

            return $data;
        }

        $res = array_recursive($this->collection, $sort);
        print_r($res);
    }

    /**
     * Метод проверяет существует ли заданный ключ в коллекции или нет
     * 
     * @param mixed $key Ключ, который нужно найти
     * @return bool
     */
    public function has(mixed $key): bool
    {
        $out = [];
        foreach ($this->collection as $k => $val) {
            if (is_array($key)) {
                $out[] = (string)in_array($k, $key);
            } else {
                $out[] = (string)$k === $key;
            }
        }

        if (is_array($key)) {
            return array_count_values($out)[1] === count($key);
        } else {
            return in_array(true, $out);
        }
    }

    /**
     * Метод проверяет существует ли заданный ключ в коллекции или нет
     *
     * @param array $keys
     * @return bool
     */
    public function hasAny(mixed $key): bool
    {
        $out = [];
        foreach ($this->collection as $k => $val) {
            if (is_array($key)) {
                $out[] = in_array($k, $key);
            } else {
                $out[] = $k === $key;
            }
        }

        return in_array(true, $out);
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
