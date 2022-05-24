<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\Status;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class ApplicationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check application\'s status for not accepted';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Application::with([
            'area'
        ])
            ->where(function (Builder $query) {
                $query->whereNull('engineer_id')
                    ->where('attempts', '<', 2)
                    ->where('status_id', '=', Status::NEW)
                    ->where('created_at', '<=', now()->subMinutes(15));
            })
            ->chunk(10, function ($applications) {
                $applications->each(function (Application $application) {
                    ++$application->attempts;
                    User::where('division_id', '=', $application->area->division_id)
                        ->whereHas('roles', function (Builder $query) {
                            $query->whereIn('slug', [
                                'head.division',
                                'engineer'
                            ]);
                        })
                        ->whereNotNull('one_signal_token')
                        ->get()
                        ->each(fn(User $user) => $user->notify(new \App\Notifications\ApplicationReminder($application)));
                    $application->save();
                });
            });

        return 0;
    }
}
