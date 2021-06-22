<?php

namespace R2FUser\Http\Controllers\Front;

use App\Http\Helpers\ResponseData;
use Illuminate\Routing\Controller;
use App\Http\Traits\FileUploadTrait;
use R2FUser\Http\Requests\KYC\StoreRequest;

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
