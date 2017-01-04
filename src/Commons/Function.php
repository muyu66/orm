<?php

/**
 * @description 删除指定KEYS，并返回
 * @param $arr
 * @param $keys
 * @return mixed
 * @author Zhou Yu
 */
function array_del($arr, $keys)
{
    if (! is_array($keys)) {
        $keys = [$keys];
    }

    foreach ($keys as $key) {
        unset($arr[$key]);
    }

    return $arr;
}

function array_fill_to($array, $num)
{
    while (count($array) < $num) {
        $array[] = null;
    }

    return $array;
}