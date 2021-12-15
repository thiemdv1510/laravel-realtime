<template>
    <div>
        <div class="input-group">
        <textarea class="form-control border-radius-4" name="message" rows="1" v-model="newMessage" @keyup.enter="sendMessage"
                  placeholder="Type your message here..."
                  @click="handleInputChat"
        ></textarea>
            <span class="input-group-btn margin-left-5">
            <button :disabled="newMessage === ''" class="btn btn-primary btn-sm height-37" id="btn-chat" @click="sendMessage">
                Send
            </button>
             <button class="btn btn-danger btn-sm height-37" type="button" @click="clearMessage">
                Clear
            </button>
        </span>
        </div>
        <file-pond
            name="imageUpload"
            ref="pond"
            label-idle="Drop and click here in order to upload the image ... "
            v-bind:allow-multiple="false"
            accepted-file-types="image/jpeg, image/png"
            server="/upload/image"
            v-on:init="handleFilePondInit"
            v-bind:files="myFiles"
            :dropOnPage="true"
            v-on:processfiles="uploadSuccess"
        />
    </div>

</template>

<script>
import vueFilePond from "vue-filepond"
import 'filepond/dist/filepond.min.css'
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

export default {
    props: ['user', 'typeprop'],
    components: {
        FilePond,
    },
    data() {
        return {
            newMessage: '',
            myFiles: [],
            image: '',
        }
    },
    computed: {
        type: {
            get () {
                return this.typeprop
            }
        }
    },

    methods: {
        async uploadSuccess () {
            await axios.post('/message/user', {userId: this.user['id']}).then(response => {
                this.image = response.data.name;
            });
            this.$emit('messagesent', {
                user: this.user,
                message: this.image,
                type: 1
            });
            this.$emit('updatetype', 1)

        },
        handleFilePondInit: function () {
            console.log("FilePond has initialized");
        },
        sendMessage() {
            this.$emit('messagesent', {
                user: this.user,
                message: this.newMessage,
                type: 0
            });
            this.$emit('updatetype', 0)
            this.newMessage = ''
        },
        clearMessage() {
            this.$emit('clearmessageall', {
                user: this.user,
                message: this.newMessage
            });
        },
        handleInputChat () {
            this.$emit('handleinputchat')
        }
    }
}
</script>

<style scoped>
    @import '../../css/styles.scss';
</style>
