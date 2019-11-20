<template>
    <div>
        <form>
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
                    @click="submitFile()"
                >
                    Upload File
                </button>
            </div>
        </form>
    </div>
</template>

<script>

export default {

    data(){
        return {
            file: null,
            waitingResponse: false,
        }
    },

    methods: {
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
        },
        submitFile() {
            this.waitingResponse = true;
            let formData = new FormData();
            formData.append('file', this.file);
            axios.post(
                `/audio-files`,
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
    },
}
</script>
