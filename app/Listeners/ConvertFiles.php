<?php

namespace App\Listeners;

use App\Events\FileSpleeted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ConvertFiles implements ShouldQueue
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
     * @param  FileSpleeted  $event
     * @return void
     */
    public function handle(FileSpleeted $event)
    {
        $sha1sum = $event->sha1sum;
        $output = [];
        $returnVar = null;
        exec("cd " . storage_path("app/spleeted_files/$sha1sum") . '&& for i in *.wav; do ffmpeg -i "$i" -acodec mp3 "${i%.*}.mp3"; done && rm *.wav', $output, $returnVar);
        if ($returnVar === 0) {
            Log::info("Converted the file source_files/$sha1sum");
            Log::info(implode("===", $output));
            return;
        }
        Log::error("Could not convert the files in spleeted_files/$sha1sum");
        Log::error(implode("===", $output));
    }
}
