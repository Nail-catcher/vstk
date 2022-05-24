<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentsResource;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return DocumentsResource
     */
    public function __invoke()
    {
        return new DocumentsResource(Document::all());
    }
}
