<?php

function get_class_name($full_path)
{
    $full_path = explode('\\', $full_path);
    return array_pop($full_path);
}
