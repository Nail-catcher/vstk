<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Services\LotusNotesService;
use Illuminate\Console\Command;

class ApplicationDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:document';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updated document for applications';

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
        Application::whereNotNull('unid')
            ->whereNull('document')
            ->whereNull('order_unid')
            ->get()
            ->each(function ($application) use ($lotus) {
                $response = $lotus->getOrderInfo($application);
                if ($response['result'] === 'SUCCESS') {
                    $application->document = $response['order_number'];
                    $application->order_unid = $response['order_unid'];
                    $application->save();
                }
            });
        return 0;
    }
}
