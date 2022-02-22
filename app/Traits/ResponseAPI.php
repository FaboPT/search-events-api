<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseAPI
{
    /**
     * Send any success response
     * @param array $data
     * @param string $nameData
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success(array $data = [], string $nameData = 'data', string $message = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return $this->coreResponse($statusCode, $data, $message, true, $nameData);
    }

    /**
     * Send any error response
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function error(string $message, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return $this->coreResponse($statusCode, [], $message, false);
    }

    /**
     * Core of response
     *
     * @param int $statusCode
     * @param array $data
     * @param string|null $message
     * @param bool $isSuccess
     * @param string $nameData
     * @return JsonResponse
     */
    private function coreResponse(int $statusCode, array $data, string $message = null, bool $isSuccess = true, string $nameData = 'data'): JsonResponse
    {
        return response()->json($this->responseData($isSuccess, $nameData, $data, $message), $statusCode);
    }

    /**
     * Method to generate the response data
     * @param bool $isSuccess
     * @param string $nameData
     * @param array $data
     * @param string|null $message
     * @return array
     */
    private function responseData(bool $isSuccess, string $nameData, array $data, string $message = null): array
    {

        return !empty($data) ?
            [
                $nameData => $data,
                'success' => $isSuccess
            ] :
            [
                'message' => $message,
                'success' => $isSuccess
            ];
    }
}
