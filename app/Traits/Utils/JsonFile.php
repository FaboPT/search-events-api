<?php

namespace App\Traits\Utils;

trait JsonFile
{
    use DateUtil;

    public function readFile($path): mixed
    {
        return json_decode(file_get_contents($path), true);
    }

    public function searchTermInJsonChild(array $child, string $search = null): bool|int|string
    {
        return array_search($search, $child);
    }

    public function searchDateInJsonChild(array $child, string $date = null): bool
    {
        return $this->parseDate($date)->between($child['startDate'], $child['endDate']);
    }
}
