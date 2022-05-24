<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeasurementStoreRequest;
use App\Models\Application;
use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param MeasurementStoreRequest $request
     * @param Application $application
     * @return \Illuminate\Http\Response
     */
    public function store(MeasurementStoreRequest $request, Application $application)
    {
        $input = $request->validated();
        $measurement = new Measurement();
        $measurement->fill($input);
        $measurement->starting()->associate($application->starting_id);
        $measurement->save();
        if (!empty($input['images'])) {
            $application->images()->whereNull('attached_at')
                ->whereIn('id', $input['images'])
                ->where('imageable_type', 'App\Models\Application')
                ->where('imageable_id', $application->id)
                ->update([
                    'imageable_type' => 'App\Models\Measurement',
                    'imageable_id' => $measurement->id,
                    'attached_at' => now()
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Measurement $measurement
     * @return \Illuminate\Http\Response
     */
    public function show(Measurement $measurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Measurement $measurement
     * @return \Illuminate\Http\Response
     */
    public function edit(Measurement $measurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Measurement $measurement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Measurement $measurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Measurement $measurement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measurement $measurement)
    {
        //
    }
}
