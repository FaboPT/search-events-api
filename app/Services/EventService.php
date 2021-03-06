<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Traits\ResponseAPI;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EventService
{
    use ResponseAPI;

    private EventRepository $eventRepository;

    /**
     *
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Search Events
     */
    public function search(array $data): JsonResponse
    {
        $json = $this->eventRepository->search($data);

        return empty($json) ?
            $this->error("Not Found Events", Response::HTTP_NOT_FOUND) :
            $this->success($json, 'events');
    }
}
