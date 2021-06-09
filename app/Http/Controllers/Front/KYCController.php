<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseData;
use App\Http\Requests\KYC\StoreRequest;
use App\Http\Traits\FileUploadTrait;
use App\Models\KYC;

class KYCController extends Controller
{
    use FileUploadTrait;

    /**
     * Upload New Document
     * @group
     * Public User > KYC
     */
    public function uploadDocuments(StoreRequest $request)
    {
        $kyc = auth()->user()->kycs()->create([
            'document_type' => $request->document_type
        ]);

        if ($this->saveFiles($request, ['file'], $kyc))
            return ResponseData::success();
        return ResponseData::error();

    }
}
