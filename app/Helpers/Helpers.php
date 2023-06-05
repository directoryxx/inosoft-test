<?php

/**
 * untuk ngecek apakah ada index tertentu dalam array dan ada isinya
 *
 * @author Angga <anggawijaya4567@gmail.co,>
 */
function has_key($key, $array)
{
    return array_key_exists($key, $array) && $array[$key] !== '' && ! is_null($array[$key]);
}