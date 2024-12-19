<?php

namespace App\Providers;

use App\Jobs\ImportCsvJob;
use Illuminate\Foundation\Application;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\QueueBusy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // max jobs count in the queue event
        Event::listen(function (QueueBusy $event) {
            Log::alert('queue jobs: ',  [
                'queue::::: ' => $event->queue,
                'size::::: ' => $event->size
            ]);
        });

        ////////////////////////////////////////

        Queue::failing(function (JobFailed $event) {
            Log::error('Job Failed', [
                // the connection job file
                'connection' => $event->connectionName,
                'job' => $event->job->getName(),
                'exception' => $event->exception->getMessage(),
            ]);

            //notify the user or any
        });
    }
}
