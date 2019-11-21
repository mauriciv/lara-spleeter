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
            return response('not yet spleeted');
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
}
