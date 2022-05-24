<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartingStocktakingRequest;
use App\Models\Application;
use App\Models\StartingStocktaking;

class StartingStocktakingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StartingStocktakingRequest $request, Application $application)
    {
        $input = $request->validated();
        $stocktaking = new StartingStocktaking();
        $stocktaking->fill($input);
        $stocktaking->starting()->associate($application->starting_id);
        $stocktaking->stocktaking()->associate($input['stocktaking']);
        $stocktaking->save();
    }
}
