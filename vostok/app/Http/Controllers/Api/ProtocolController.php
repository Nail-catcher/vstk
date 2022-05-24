<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProtocolStoreRequest;
use App\Http\Resources\ProtocolResource;
use App\Http\Resources\ProtocolsResource;
use App\Models\Application;
use App\Models\Protocol;
use App\Models\Starting;
use Illuminate\Http\Request;

class ProtocolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Application $application
     * @param Starting $starting
     * @return ProtocolsResource
     */
    public function index(Application $application, Starting $starting): ProtocolsResource
    {
        return new ProtocolsResource($starting->protocols);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProtocolStoreRequest $request
     * @param Application $application
     * @return ProtocolResource
     */
    public function store(ProtocolStoreRequest $request, Application $application): ProtocolResource
    {
        $input = $request->validated();
        $protocol = new Protocol();
        $protocol->fill($input);
        $protocol->starting()->associate($application->starting_id);
        $protocol->group()->associate($input['group']);
        $protocol->battery()->associate($input['battery']);
        $protocol->save();
        return new ProtocolResource($protocol);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Protocol $protocol
     * @return \Illuminate\Http\Response
     */
    public function show(Protocol $protocol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Protocol $protocol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Protocol $protocol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Protocol $protocol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protocol $protocol)
    {
        //
    }
}
