<?php

namespace App\Http\Controllers;

use App\Events\FileUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioFilesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'audio_file' => [
                'mimes:mpga,mp2,mp2a,mp3,m2a,m3a',
                'max:10000',
            ],
        ]);

        $uploadedFile = $request->file('audio_file');

        $sha1sum = sha1_file($uploadedFile->path());

        if (!Storage::exists('source_files/'.$sha1sum)) {
            $uploadedFile->storeAs('source_files', $sha1sum);
        }

        event(new FileUploaded($sha1sum));

        return response($sha1sum);
    }
}
