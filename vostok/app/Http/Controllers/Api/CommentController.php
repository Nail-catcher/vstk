<?php

namespace App\Http\Controllers\Api;

use App\Actions\Applications\CreateNewComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStore;
use App\Http\Resources\CommentResource;
use App\Models\Application;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CommentStore $request
     * @param Application $application
     * @return CommentResource
     */
    public function store(CommentStore $request, Application $application): CommentResource
    {
        $comment = (new CreateNewComment())->create($application, $request->validated());
        return new CommentResource($comment);
    }
}
