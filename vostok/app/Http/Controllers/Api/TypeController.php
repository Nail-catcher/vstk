<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Http\Resources\TypesResource;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return TypesResource
     */
    public function index(Request $request): TypesResource
    {
        return new TypesResource(Type::all());
    }

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Type $type
     * @return TypeResource
     */
    public function show(Request $request, Type $type): TypeResource
    {
        return new TypeResource($type->load('types'));
    }
}
