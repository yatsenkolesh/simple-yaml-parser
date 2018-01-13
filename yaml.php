<?php

/**
 * @param string $path
 * @return array|boolean
 */
function simple_parse_yaml($path = '')
{
    $values = [];
    $linesSeparator = "\n";
    $lastChrCategory = ':';
    $firstChrValue = '-';

    if (!file_exists($path) || !is_readable($path)) {
        return false;
    }

    if (!$content = file_get_contents($path)) {
        return false;
    }

    $lines = explode($linesSeparator, $content);
    $category = '';

    foreach ($lines as $line) {
        if ($line == '---') {
            continue;
        }

        $line = trim($line);

        if (empty($line)) {
            continue;
        }

        $lastChr = substr($line, -1);
        $firstChr = substr($line, 0,1);
        if ($lastChr == $lastChrCategory) {
            $category = substr($line, 0, -1);
        }
        elseif ($firstChr == $firstChrValue) {
            $values[$category][] = trim(substr($line, 1));
        }
    }

    return $values;
}
