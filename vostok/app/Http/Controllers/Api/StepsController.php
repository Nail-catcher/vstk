<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Steps;
use App\Models\Progress;
use App\Models\StepsProgress;
use App\Http\Requests\StepsFilter;
use App\Http\Resources\StepsResource;
class StepsController extends Controller
{
    public function __invoke(StepsFilter $request):StepsResource
    {
    	$input = $request->validated();	
    	
        return new StepsResource(Progress::find($input['progress'])->steps);
    }
}
