<?php

namespace App\Repositories;

use App\Traits\Utils\JsonFile;

class EventRepository
{
    use JsonFile;
    /**
     * Search Events
     */
    public function search(array $data): array
    {
        return $this->searchInFile($this->readFile(database_path('data.json')), $this->containsParameter($data, 'term'), $this->containsParameter($data, 'date'));
    }


    private function searchInFile(mixed $json, string $term = null, string $date = null): array
    {
        if (!$term && !$date)
            return $json;

        $response = [];

        foreach ($json as $item) {
            $searchTerm = $this->searchTermInJsonChild($item, $term);
            $isDate = $this->searchDateInJsonChild($item, $date);
            $isCountryOrCity = $this->isCountryOrCity($searchTerm);
            $bothParameters = $isCountryOrCity && $isDate;
            $onlyTerm = $isCountryOrCity && !$isDate && $term && !$date;
            $onlyDate = !$isCountryOrCity && $isDate && !$term && $date;

            if ($bothParameters || $onlyTerm || $onlyDate) {
                $response[] = $item;
            }

        }
        return $response;
    }

    private function containsParameter(array $data, $parameter): mixed
    {
        return $data[$parameter] ?? null;
    }

    private function isCountryOrCity(bool|int|string $search): bool
    {
        return $search === "country" || $search === "city";
    }


}
