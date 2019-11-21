<template>
    <div>
        <form
            v-if="!fileSent"
            enctype="multipart/form-data"
        >
            <div class="p-2 flex flex-col items-center">
                <input
                    ref="file"
                    class="my-2"
                    type="file"
                    @change="handleFileUpload()"
                >
                <button
                    class="hover:bg-purple-800 border border-purple-800 text-purple-800 hover:text-white bg-white my-2 px-4 py-2 rounded shadow"
                    :class="{ 'cursor-not-allowed opacity-50': waitingResponse }"
                    :disabled="waitingResponse || file === null"
                    @click.prevent="submitFile()"
                >
                    Upload File
                </button>

            </div>
        </form>
        <div v-if="filename" class="m-2">
            {{ filename }}
        </div>
        <div v-if="fileHasBeenSpleeted" class="m-2">
            {{ filename }} has been spleeted
        </div>
        <div v-if="fileHasBeenConverted" class="m-2">
            {{ filename }} files have been converted
        </div>
        <div v-if="fileHasBeenConverted">
            <button
                class="hover:bg-blue-800 border border-blue-800 text-blue-800 hover:text-white bg-white my-2 px-4 py-2 rounded shadow"
                @click="toggleAll"
            >
                Play All
            </button>
        </div>
        <div v-for="file in convertedFiles" class="m-2">
            <audio
                controls
                :src="`/storage/${file}`"
                :ref="getFilename(file, true)"
                class="w-full lg:w-1/2 mx-auto"
                >
                    Your browser does not support the
                    <code>audio</code> element.
            </audio>
            <a :href="`/storage/${file}`" class="text-lg text-teal-700 underline" download>
                {{ getFilename(file) }} Download
            </a>
        </div>
    </div>
</template>

<script>

export default {

    beforeDestroy () {
        clearInterval(this.$options.interval)
    },

    data(){
        return {
            file: null,
            waitingResponse: false,
            fileSent: false,
            fileHasBeenSpleeted: false,
            fileHasBeenConverted: false,
            filename: '',
            convertedFiles: [],
            playing: false,
            audioElements: {},
            audioIsSetUp: false,
        }
    },

    methods: {
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
        },
        submitFile() {
            this.waitingResponse = true;
            let formData = new FormData();
            formData.append('audio_file', this.file);
            axios.post(
                '/audio-files',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }
            ).then(response => {
                console.log('SENT');
                console.log(response);
                this.file = null;
                this.filename = response.data;
                this.fileSent = true;
                this.checkIfFileHasBeenSpleeted();
            }).catch(error => {
                console.debug(error);
                for (const key in error) {
                    if (error.hasOwnProperty(key)) {
                        const element = error[key];
                        console.debug(element);
                    }
                }
            }).finally(() => this.waitingResponse = false);
        },
        checkIfFileHasBeenSpleeted() {
            console.log('CALLED checkIfFileHasBeenSpleeted');
            axios.get(`/spleeted-files/${this.filename}`)
                .then(({data}) => {
                    if (data === 'not yet spleeted') {
                        setTimeout(this.checkIfFileHasBeenSpleeted, 1000);
                        return;
                    }
                    this.fileHasBeenSpleeted = true;
                    this.checkIfFileHasBeenConverted()
            }).catch(error => {
                console.debug(error);
                for (const key in error) {
                    if (error.hasOwnProperty(key)) {
                        const element = error[key];
                        console.debug(element);
                    }
                }
            });
        },
        checkIfFileHasBeenConverted() {
            console.log('CALLED checkIfFileHasBeenConverted');
            axios.get(`/spleeted-files/${this.filename}`)
                .then(({data}) => {
                    if (data === 'not yet converted') {
                        setTimeout(this.checkIfFileHasBeenConverted, 1000);
                        return;
                    }
                    this.fileHasBeenConverted = true;
                    this.convertedFiles = data;
            }).catch(error => {
                console.debug(error);
                for (const key in error) {
                    if (error.hasOwnProperty(key)) {
                        const element = error[key];
                        console.debug(element);
                    }
                }
            });
        },
        getFilename(url, withoutExtension = false) {
            let segments = url.split('/');
            let filename = segments[segments.length - 1];
            if (withoutExtension) {
                let filenameSegments = filename.split('.');
                return filenameSegments[0];
            }
            return filename;
        },
        setupAudio() {
            const audioContext = new AudioContext();

            this.audioElements.vocals = this.$refs.vocals[0];
            const vocalsTrack = audioContext.createMediaElementSource(this.audioElements.vocals);
            vocalsTrack.connect(audioContext.destination);

            this.audioElements.drums = this.$refs.drums[0];
            const drumsTrack = audioContext.createMediaElementSource(this.audioElements.drums);
            drumsTrack.connect(audioContext.destination);

            this.audioElements.bass = this.$refs.bass[0];
            const bassTrack = audioContext.createMediaElementSource(this.audioElements.bass);
            bassTrack.connect(audioContext.destination);

            this.audioElements.piano = this.$refs.piano[0];
            const pianoTrack = audioContext.createMediaElementSource(this.audioElements.piano);
            pianoTrack.connect(audioContext.destination);

            this.audioElements.other = this.$refs.other[0];
            const otherTrack = audioContext.createMediaElementSource(this.audioElements.other);
            otherTrack.connect(audioContext.destination);
        },
        toggleAll() {
            if (!this.audioIsSetUp) {
                this.setupAudio();
            }
            if (this.playing) {
                for (const key in this.audioElements) {
                    if (this.audioElements.hasOwnProperty(key)) {
                        const audioElement = this.audioElements[key];
                        audioElement.pause();
                    }
                }
                this.playing = false;
                return
            }
            for (const key in this.audioElements) {
                if (this.audioElements.hasOwnProperty(key)) {
                    const audioElement = this.audioElements[key];
                    audioElement.play();
                }
            }
            this.playing = true;
        },
    },
}
</script>
