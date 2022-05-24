<?php

namespace App\Console\Commands;

use App\Models\Application;
use Illuminate\Console\Command;

class ApplicationOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Application::with(['user', 'dispatcher'])
            ->where('deadline_at', '<', now())
            ->where('overdue_attempts', '=', 0)
            ->active()
            ->chunk(10, function ($applications) {
                $applications->each(function (Application $application) {
                    $application->user->notify(new \App\Notifications\ApplicationOverdue($application));
                    $application->dispatcher->notify(new \App\Notifications\ApplicationOverdue($application));
                    ++$application->overdue_attempts;
                    $application->save();
                });
            });
        return 0;
    }
}
