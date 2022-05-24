<?php


namespace App\Actions\Users;


use App\Models\User;
use App\Models\Vacation;

class UpdateUser
{
    public function updateStatus(User $user, array $input)
    {
        $this->updateVacation($user, $input);
        $user->status()->associate($input['status']);
        $user->save();
    }

    public function updateVacation(User $user, array $input): void
    {
        if ($user->vacations()->where('status_id', '=', $user->status_id)->whereNull('ended_at')->exists()) {
            $vacation = $user->vacations()->where('status_id', '=', $user->status_id)->whereNull('ended_at')->first();
            $vacation->ended_at = now();
            $vacation->save();
        }

        if (in_array($input['status'], [3, 4, 5], true)) {
            $vacation = new Vacation();
            $vacation->status()->associate($input['status']);
            $vacation->started_at = $input['started_at'];
            $vacation->ended_at = $input['deadline_at'];
            $user->vacations()->save($vacation);
        }
    }
}
