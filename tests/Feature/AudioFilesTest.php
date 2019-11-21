<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AudioFilesTest extends TestCase
{
    /** @test */
    public function an_event_is_emitted_when_an_audio_file_is_uploaded()
    {
        Storage::fake();

        $file = UploadedFile::fake()->image();
    }
}
