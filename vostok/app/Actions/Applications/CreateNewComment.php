<?php


namespace App\Actions\Applications;


use App\Models\Application;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CreateNewComment
{
    public function create(Application $application, array $input)
    {
        $comment = new Comment();
        $comment->comment = $input['comment'];
        $comment->application()->associate($application);
        $comment->user()->associate(Auth::id());
        $comment->save();
        return $comment;
    }
}
