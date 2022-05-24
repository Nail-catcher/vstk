<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationsResource;
use App\Models\Area;
use App\Models\Project;
use App\Models\Status;
use App\Models\Type;
use App\Models\Work;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TypeController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param \App\Models\Type $type
     * @return \Inertia\Response
     */
    public function show(Request $request, Type $type): \Inertia\Response
    {
        $applications = $type->applications()->with('user', 'project', 'stations', 'type', 'work', 'status');
        return Inertia::render('Applications/Index', [
            'type' => $type,
            'applications' => new ApplicationsResource($applications->paginate()->appends($request->all())),
            'statuses' => Status::all(),
            'areas' => Area::all(),
            'works' => Work::all(),
            'projects' => Project::all(),
            'types' => Type::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Type $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        //
    }
}
