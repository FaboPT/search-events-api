<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Traits\ResponseAPI;
use Illuminate\Http\JsonResponse;


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
        $this->success($this->eventRepository->search($data), 'events');
    }
}
