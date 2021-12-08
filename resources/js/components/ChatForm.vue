<template>
    <div class="input-group">
        <input id="btn-input" type="text" name="message" class="form-control input-sm border-radius-4" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">

        <span class="input-group-btn margin-left-5">
            <button class="btn btn-primary btn-sm height-37" id="btn-chat" @click="sendMessage">
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
            newMessage: ''
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
        }
    }
}
</script>

<style scoped>
    @import '../../css/styles.scss';
</style>
