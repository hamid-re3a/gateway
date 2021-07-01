<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseData;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Get All Settings
     * @group
     * General
     */
    public function index()
    {
        return ResponseData::success(trans('responses.ok'),Setting::all());
    }
}
