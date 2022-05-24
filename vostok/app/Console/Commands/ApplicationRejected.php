<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Status;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class ApplicationRejected extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:rejected';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change application\'s status to rejected';

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
        $builder = Application::with('dispatcher')
            ->Where(function (Builder $query) {
                $query->where('attempts', '>=', 2)
                    ->where('status_id', '=', Status::NEW);

            });
        $applications = $builder->get();
        $applications->each(function (Application $application) {
            $status = new ApplicationStatus([
                'status_id' => $application->status_id,
            ]);
            $status->old_status()->associate($application->status_id);
            $status->status()->associate(Status::REJECTED);
            $status->application()->associate($application);
            $status->save();
            if ($application->dispatcher->one_signal_token !== null) {
                $application->dispatcher->notify(new \App\Notifications\ApplicationRejected($application));
            }
        });
        $builder->update([
            'status_id' => Status::REJECTED
        ]);
        return 0;
    }
}
