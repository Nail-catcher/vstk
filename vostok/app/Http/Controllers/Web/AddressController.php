<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressFilter;
use App\Http\Resources\AddressesResource;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return AddressesResource
     */
    public function __invoke(AddressFilter $request): AddressesResource
    {
        return new AddressesResource(Address::filter($request->validated())->get());
    }
}
