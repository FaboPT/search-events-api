<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/access-search-endpoint.log'),
        ])->info('User ' . Auth::user()->name . ' search ' . implode(' and ', $request->all()));


        return $this->eventService->search($request->all());
    }
}
