<?php

namespace App\Console\Commands;

use App\Models\Route;
use Illuminate\Console\Command;

class RouteOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check route\'s status for is overdue';

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
        Route::with('user')
            ->where('deadline_at', '<', now())
            ->where('attempts', '=', 0)
            ->active()
            ->chunk(10, function ($routes) {
                $routes->each(function (Route $route) {
                    $route->user->notify(new \App\Notifications\RouteOverdue($route));
                    ++$route->attempts;
                    $route->save();
                });
            });
        return 0;
    }
}
