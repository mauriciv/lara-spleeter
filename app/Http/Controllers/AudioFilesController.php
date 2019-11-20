<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'file' => 'mimes:mp3',
        ]);

        return response('All good');
    }
}
