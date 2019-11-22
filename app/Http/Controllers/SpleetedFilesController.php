<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpleetedFilesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sha1sum)
    {
        if (!Storage::exists("spleeted_files/$sha1sum")) {
            return $this->getCompletionPercentage($sha1sum);
        }
        $files = Storage::files("spleeted_files/$sha1sum");
        $audioFiles = collect($files)->filter(function ($file) {
            return Str::endsWith($file, 'wav');
        });
        if ($audioFiles->isNotEmpty()) {
            return response('not yet converted');
        }
        return Storage::files("spleeted_files/$sha1sum");
    }

    public function getCompletionPercentage($sha1sum)
    {
        $files = Storage::files("ffmpeg-split");
        $splitFiles = collect($files)->filter(function ($file) use ($sha1sum) {
            return Str::startsWith($file, "ffmpeg-split/$sha1sum");
        });
        if ($splitFiles->isEmpty()) {
            return 0;
        }
        $spleetedDirs = collect(Storage::directories("ffmpeg-split/spleeted_files/"));
        return ($spleetedDirs->count() / $splitFiles->count()) * 100;
    }
}
