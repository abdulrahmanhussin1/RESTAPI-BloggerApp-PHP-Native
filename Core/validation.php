<?php

function sanitizeInput($input)
{
    return trim(htmlentities(htmlspecialchars(str_replace(array("#", "'", ";", "$", "%", "&", "<", ">", "/", "*"), '', $input))));
}

function requiredInput($input)
{
    if (empty($input)) {
        return true;
    }
    return false;
}

function minLength($input, $minLength)
{
    if (strlen($input) < $minLength) {
        return true;
    }
    return false;
}


function maxLength($input, $maxLength)
{
    if (strlen($input) > $maxLength) {
        return true;
    }
    return false;
}

function emailInput($input)
{
    if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

function numericInput($input)
{
    if (is_numeric($input)) {
        return true;
    }
    return false;
}

function inArrayInput($input, $array)
{
    if (!in_array($input, $array)) {
        return true;
    }
    return false;
}
