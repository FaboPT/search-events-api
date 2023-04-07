<?php

namespace App\Traits\Utils;

use JsonException;

trait JsonFile
{
    use DateUtil;

    /**
     * @throws JsonException
     */
    public function readFile($path): mixed
    {
        return json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    }

    public function searchTermInJsonChild(array $child, string $search = null): bool|int|string
    {
        return array_search($search, $child, true);
    }

    public function searchDateInJsonChild(array $child, string $date = null): bool
    {
        return $this->parseDate($date)->between($child['startDate'], $child['endDate']);
    }
}
