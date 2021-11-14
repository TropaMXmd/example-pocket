<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Prepare json success response
     * 
     *
     * @param string $message
     * @param string $type
     * @param int $code
     * @param array $data
     * 
     * @return json response
     */
    public function respond($message, $type = 'success', $code = 200, $data = [])
    {
        $response = [
            'message' => $message,
            'type' => $type,
            'code' => $code
        ];

        if (!!$data) {
             $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Prepare json error response
     * 
     *
     * @param int $code
     * @param array $data
     * @param string $message
     * 
     * @return json response
     */
    public function errorResponse($code = 400, $data = [], $message = 'Something went wrong! Please try again.')
    {
        $response = [
            'message' => $message,
            'type' => 'error',
            'code' => $code
        ];

        if (!!$data)
            $response['errors'] = $data;

        return response()->json($response, $code);
    }
}
