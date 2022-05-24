<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DivisionsResource;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return DivisionsResource
     */
    public function __invoke(Request $request): DivisionsResource
    {
        return new DivisionsResource(Division::all());
    }
}
