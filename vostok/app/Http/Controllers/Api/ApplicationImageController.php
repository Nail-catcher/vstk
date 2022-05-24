<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationImageStore;
use App\Models\Application;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationImageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Application $application
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ApplicationImageStore $request, Application $application)
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
        $image->application()->associate($application);
        $image->save();
    }
}
