<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationImageStore;
use App\Http\Resources\ImagesResource;
use App\Models\Application;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Application $application
     * @return ImagesResource
     */
    public function index(Application $application): ImagesResource
    {
        return new ImagesResource($application->images()->whereNull('attached_at')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApplicationImageStore $request
     * @param Application $application
     * @return ImagesResource
     */
    public function store(ApplicationImageStore $request, Application $application): ImagesResource
    {
        $input = $request->validated();
        $image_name = Str::random(64) . '.' . Str::after($input['photo_type'], '/');
        $image_path = "applications/{$application->id}/{$image_name}";
        Storage::disk('public')->put(
            $image_path,
            base64_decode($input['photo_body'])
        );
        $image = new Image([
            'path' => $image_path
        ]);
        $application->images()->save($image);

        return new ImagesResource($application->images()->whereNull('attached_at')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Application $application
     * @param Image $image
     * @return ImagesResource
     * @throws \Exception
     */
    public function destroy(Application $application, Image $image)
    {
    
        $image->delete();
        return new ImagesResource($application->images()->whereNull('attached_at')->get());
    }
}
