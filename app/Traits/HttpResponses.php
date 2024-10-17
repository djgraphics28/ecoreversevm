<?php

namespace App\Traits;

trait HttpResponses
{
    /**
     * Success Response
     *
     * @param string $message
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = [], $message, $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Error Response
     *
     * @param string $message
     * @param array|null $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($data = null, $message, $statusCode = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Not Found Response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notFound($message = 'Resource not found')
    {
        return $this->error(null, $message, 404);
    }

    /**
     * Unauthorized Response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthorized($message = 'Unauthorized')
    {
        return $this->error(null, $message, 401);
    }
}
