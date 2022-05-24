<?php

namespace App\Http\Controllers;

use App\Actions\Applications\CreateNewComment;
use App\Http\Requests\CommentStore;
use App\Models\Application;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CommentStore $request
     * @param Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentStore $request, Application $application): \Illuminate\Http\RedirectResponse
    {
        (new CreateNewComment())->create($application, $request->validated());
        return redirect()->back();
    }
}
