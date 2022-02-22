<?php

namespace App\Repositories;

use Carbon\Carbon;

class EventRepository
{
    /**
     * Search Events
     */
    public function search(array $data): array
    {
        return $this->searchInFile($this->readFile(), $this->containsParameter($data, 'term'), $this->containsParameter($data, 'date'));
    }

    /**
     *
     */

    private function searchInFile(mixed $json, string $term = null, string $date = null)
    {
        if (!$term && !$date)
            return $json;

        $response = [];

        foreach ($json as $item) {
            $searchTerm = $this->searchTermInJsonChild($item, $term);
            $isDate = $this->searchDateInJsonChild($item, $date);

            if (($this->isCountryOrCity($searchTerm) && $isDate) || ($this->isCountryOrCity($searchTerm) && !$isDate && $term && !$date) ||
                !$this->isCountryOrCity($searchTerm) && $isDate && !$term && $date) {
                $response[] = $item;
            }

        }
        return $response;
    }

    private function readFile(): mixed
    {
        return json_decode(file_get_contents(database_path('data.json')), true);
    }

    private function containsParameter(array $data, $parameter): mixed
    {
        return $data[$parameter] ?? null;
    }


    private function searchTermInJsonChild(array $child, string $search = null): bool|int|string
    {
        return array_search($search, $child);
    }

    private function searchDateInJsonChild(array $child, string $date = null): bool
    {
        return $this->parseDate($date)->between($child['startDate'], $child['endDate']);
    }

    private function isCountryOrCity(bool|int|string $search): bool
    {
        return $search === "country" || $search === "city";
    }

    private function parseDate($date): Carbon
    {
        return Carbon::parse($date);
    }
}
