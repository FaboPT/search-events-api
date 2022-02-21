<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    private EventService $eventService;

    /**
     *
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @param EventRequest $request
     * @return JsonResponse
     */
    public function search(EventRequest $request): JsonResponse
    {
        dd($request->all());
        $this->eventService->search($request->all());
    }
}
