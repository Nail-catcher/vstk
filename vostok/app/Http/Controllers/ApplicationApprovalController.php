<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Status;
use App\Services\LotusNotesService;
use Illuminate\Http\Request;

class ApplicationApprovalController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request): \Illuminate\Http\RedirectResponse
    {
        $input = $request->all();
        $applications = Application::with(['users', 'stations', 'area', 'user', 'project', 'work', 'type'])
            ->whereIn('id', $input['applications'])
            ->whereIn('status_id', [
                Status::ACCEPTED, Status::IN_WORK
            ])
            ->has('users')
            ->whereNull('document')
            ->whereNull('unid')
            ->get();
        $lotus = new LotusNotesService();
        $applications->each(function ($application) use ($lotus) {
            $response = $lotus->createRequest($application);
            if (!empty($response !== null && $response['result'] === 'SUCCESS')) {
                $application->unid = $response['UNID'];
                $application->save();
            }
        });

        return redirect()->back();
    }
}
