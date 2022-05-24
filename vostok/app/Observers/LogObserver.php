<?php

namespace App\Observers;

use App\Events\HistoryUpdated;
use App\Models\LogMagazine;

class LogObserver
{
    /**
     * Handle the LogMagazine "created" event.
     *
     * @param \App\Models\LogMagazine $logMagazine
     * @return void
     */
    public function created(LogMagazine $logMagazine)
    {

        broadcast(new HistoryUpdated($logMagazine));
    }

    /**
     * Handle the LogMagazine "updated" event.
     *
     * @param \App\Models\LogMagazine $logMagazine
     * @return void
     */
    public function updated(LogMagazine $logMagazine)
    {
        broadcast(new HistoryUpdated($logMagazine));
    }

    /**
     * Handle the LogMagazine "deleted" event.
     *
     * @param \App\Models\LogMagazine $logMagazine
     * @return void
     */
    public function deleted(LogMagazine $logMagazine)
    {
        // broadcast(new HistoryUpdated($logMagazine));
    }

    /**
     * Handle the LogMagazine "restored" event.
     *
     * @param \App\Models\LogMagazine $logMagazine
     * @return void
     */
    public function restored(LogMagazine $logMagazine)
    {
        //broadcast(new HistoryUpdated($logMagazine));
    }

    /**
     * Handle the LogMagazine "force deleted" event.
     *
     * @param \App\Models\LogMagazine $logMagazine
     * @return void
     */
    public function forceDeleted(LogMagazine $logMagazine)
    {
        //broadcast(new HistoryUpdated($logMagazine));
    }
}
