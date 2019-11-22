<?php

namespace App\Listeners;

use App\Events\FileSpleeted;
use App\Events\FileUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SpleetFile implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FileUploaded  $event
     * @return void
     */
    public function handle(FileUploaded $event)
    {
        $sha1sum = $event->sha1sum;
        if (!Storage::exists("source_files/$sha1sum")) {
            Log::error("File source_files/$sha1sum does not exist");
        }

        if (Storage::exists("spleeted_files/$sha1sum")) {
            Log::info("File source_files/$sha1sum already spleeted, skipping.");
            return;
        }
        $output = [];
        $returnVar = null;
        $output = system("./spleet-file.sh $sha1sum", $returnVar);

        if ($returnVar !== 0) {
            Log::error("Could not spleet file source_files/$sha1sum");
            Log::info($output);
            return;
        }

        event(new FileSpleeted($sha1sum));
    }
}
