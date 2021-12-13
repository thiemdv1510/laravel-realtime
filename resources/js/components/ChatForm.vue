<template>
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
</template>

<script>
export default {
    props: ['user'],

    data() {
        return {
            newMessage: '',

        }
    },

    methods: {
        sendMessage() {
            this.$emit('messagesent', {
                user: this.user,
                message: this.newMessage
            });

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
