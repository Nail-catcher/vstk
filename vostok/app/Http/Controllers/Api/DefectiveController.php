<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DefectiveStoreRequest;
use App\Http\Resources\DefectiveResource;
use App\Http\Resources\DefectivesResource;
use App\Models\Application;
use App\Models\Defective;
use Illuminate\Http\Request;

class DefectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Application $application
     * @return DefectivesResource
     */
    public function index(Application $application): DefectivesResource
    {
        if ($application->starting_id === null) {
            abort(404);
        }
        return new DefectivesResource($application->lastStarting->defectives);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DefectiveStoreRequest $request
     * @param Application $application
     * @return DefectiveResource
     */
    public function store(DefectiveStoreRequest $request, Application $application)
    {
        $input = $request->validated();
        $defective = new Defective();
        $defective->fill($input);
        $defective->starting()->associate($application->starting_id);
        $defective->save();
        return new DefectiveResource($defective);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Defective $defective
     * @return \Illuminate\Http\Response
     */
    public function show(Defective $defective)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Defective $defective
     * @return \Illuminate\Http\Response
     */
    public function edit(Defective $defective)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Defective $defective
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Defective $defective)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Defective $defective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Defective $defective)
    {
        //
    }
}
