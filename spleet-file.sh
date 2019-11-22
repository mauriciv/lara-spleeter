#!/bin/bash
cd storage/app/ffmpeg-split
# split the files into smaller ones so we don't run out of memory
ffmpeg -i ../source_files/"$1" -f segment -segment_time 20 -c copy "$1"%03d.mp3

spleeter separate -i "$1"*.mp3 -p spleeter:5stems -o spleeted_files
# concatenate all the files again
ffmpeg -f concat -safe 0 -i <(for f in ./spleeted_files/"$1"*/bass.wav; do echo "file '$PWD/$f'"; done) -c copy bass.wav
ffmpeg -f concat -safe 0 -i <(for f in ./spleeted_files/"$1"*/drums.wav; do echo "file '$PWD/$f'"; done) -c copy drums.wav
ffmpeg -f concat -safe 0 -i <(for f in ./spleeted_files/"$1"*/other.wav; do echo "file '$PWD/$f'"; done) -c copy other.wav
ffmpeg -f concat -safe 0 -i <(for f in ./spleeted_files/"$1"*/piano.wav; do echo "file '$PWD/$f'"; done) -c copy piano.wav
ffmpeg -f concat -safe 0 -i <(for f in ./spleeted_files/"$1"*/vocals.wav; do echo "file '$PWD/$f'"; done) -c copy vocals.wav
# move the files to the expected location
mkdir -p ../spleeted_files/"$1"
mv *.wav -t ../spleeted_files/"$1"
# cleanup
rm -rf *.mp3 *.wav spleeted_files