<?php

namespace ApiResponse\Facades;

use ApiResponse\ApiResponse;
use Illuminate\Support\Facades\Facade;

use ApiResponse\Contracts\ApiInterface;

/**
 * @method static ApiResponse response($status, $message, $data, ...$extraData)
 * @method static ApiResponse success($message = null, $data = [],$status = 200, ...$extraData)
 * @method static ApiResponse error($message = null, $data = [], $status = 400, $errors = [], ...$extraData)
 * @method static ApiResponse ok($message = null, $data = [], ...$extraData)
 * @method static ApiResponse notFound($message = null)
 * @method static ApiResponse validation($message = null, $errors = [], ...$extraData)
 *
 * @see APIResponse
 */
class API extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ApiInterface::class;
    }
}
