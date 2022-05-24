<?php

namespace App\Console\Commands;

use App\Models\Route;
use App\Services\LotusNotesService;
use Illuminate\Console\Command;

class RouteDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'routes:document';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updated document for routes';

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
        $lotus = new LotusNotesService();
        Route::whereNotNull('unid')
            ->whereNull('order_number')
            ->whereNull('order_unid')
            ->get()
            ->each(function ($route) use ($lotus) {
                $response = $lotus->getOrderInfo($route);
                if ($response['result'] === 'SUCCESS') {
                    $route->order_number = $response['order_number'];
                    $route->order_unid = $response['order_unid'];
                    $route->save();
                }
            });
        return 0;
    }
}
