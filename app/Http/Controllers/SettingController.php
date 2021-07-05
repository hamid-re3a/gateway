<?php

namespace App\Http\Controllers;


use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Get All Settings
     * @group
     * General
     * @unauthenticated
     */
    public function index()
    {
        return api()->success(trans('responses.ok'),Setting::all());
    }
}
