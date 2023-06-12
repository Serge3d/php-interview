<?php

$array = [
    ['id' => 1, 'date' => "12.01.2020", 'name' => "test1"],
    ['id' => 2, 'date' => "02.05.2020", 'name' => "test2"],
    ['id' => 4, 'date' => "08.03.2020", 'name' => "test4"],
    ['id' => 1, 'date' => "22.01.2020", 'name' => "test1"],
    ['id' => 2, 'date' => "11.11.2020", 'name' => "test4"],
    ['id' => 3, 'date' => "06.06.2020", 'name' => "test3"],
];

/**
 * 1. Выделить уникальные записи (убрать дубли) в отдельный массив.
 * В конечном массиве не должно быть элементов с одинаковым id.
 *
 * @param array $array
 * @param string $key
 * @return array
 */
function unique_by_key(array $array, string $key): array
{
    return array_values(array_combine(array_column($array, $key), $array));
}

/**
 * 2. Отсортировать многомерный массив по ключу (любому)
 *
 * @param array $array
 * @param string $key
 * @param bool $desc
 * @return array
 */
function sort_by_key(array $array, string $key, bool $desc = false): array
{
    usort($array, function ($a, $b) use ($key, $desc) {
        if ($a[$key] == $b[$key]) {
            return 0;
        }

        $compare = ($a[$key] < $b[$key]) ? -1 : 1;
        return $desc ? -$compare : $compare;
    });

    return $array;
}

/**
 * 3. Вернуть из массива только элементы, удовлетворяющие внешним условиям (например элементы с определенным id)
 * я наверно не правильно понял суть задания
 *
 * @param array $array
 * @param callable $callback
 * @return array
 */
function filter_by_callback(array $array, callable $callback): array
{
    return array_values(array_filter($array, $callback));
}

/**
 * 4. Изменить в массиве значения и ключи (использовать name => id в качестве пары ключ => значение)
 * я наверно не правильно понял суть задания
 *
 * @param array $array
 * @param string $column_key
 * @param string $index_key
 * @return array
 */
function custom_array_column(array $array, string $column_key, string $index_key): array
{
    return array_column($array, $column_key, $index_key);
}

// 5.  Выведите id и названия всех товаров, которые имеют все возможные теги в этой базе.
$goodsQuery = '
    select goods.id, goods.name
    from goods
    join goods_tags on goods.id = goods_tags.good_id
    join tags on goods_tags.tag_id = tags.id
    group by goods.id
    having count(tags.id) = (select count(*) from tags)
';

// 6. Выбрать без join-ов и подзапросов все департаменты, в которых есть мужчины, и все они (каждый) поставили высокую оценку (строго выше 5).
$departmentsQuery = '
    select department_id
    from evaluations
    where gender = 1
    group by department_id
    having min(evaluations.value) > 5
';

$result = [
    'unique' => unique_by_key($array, 'id'),
    'sort' => sort_by_key($array, 'id'),
    'filter' => filter_by_callback($array, fn($item) => $item['id'] > 2),
    'column' => custom_array_column($array, 'id', 'name')
];

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);