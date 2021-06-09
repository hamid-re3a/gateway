<?php


namespace App\Http\Helpers;


class ResponseData
{
    public static function success($message = 'success', $data = null, $status = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ])->setStatusCode($status);
    }

    public static function error($message = 'failure', $data = null, $status = 400)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ])->setStatusCode($status);
    }

    public static function status($message = '', $status = 200)
    {
        return [
            'message' => $message,
            'status' => $status
        ];
    }
}
