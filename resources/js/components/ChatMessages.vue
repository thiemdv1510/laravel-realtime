<template>
    <ul class="chat list-style-none">
        <li @click="hoverItemMessage(message.id)" @mouseover="hoverItemMessage(message.id)" @mouseleave="outHover" class="clearfix" :class="{'justify-end': message.position === 'right', 'justify-start': message.position === 'left'}" v-for="message in messages">
            <div class="chat-body clearfix flex direction-column" :class="{'right': message.position === 'right', 'left': message.position === 'left','padding-right-26': !message.showIcon}">
                <span class="format-sub-info padding-right-5 right" v-if="message.position === 'right' && select === message.id">{{message.date}} </span>
                <span class="format-sub-info padding-left-5 left" v-if="message.position === 'left' && select === message.id">{{message.date}} </span>
                <div :class="{'direction-row': message.showIcon && message.position === 'right'}">
                    <p :class="{'chat-me': message.position === 'right', 'chat-dont-me': message.position === 'left', 'padding-left-16': message.showIcon && message.position === 'right'}">
                        {{ message.message }}
                    </p>
                    <iframe v-if="message.showIcon && message.position === 'right'" :class="message.read === 1 ? 'check-sended' : 'check-send'" width="20px" height="20px" src="./image/check.svg"></iframe>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['messages', 'selecthover'],

    computed: {
        select: {
            get() {
                return this.selecthover
            }
        }
    },

    methods: {
        hoverItemMessage (id) {
            this.$emit('hoveritemmessage', id)
        },
        outHover () {
            this.$emit('outhover')
        }
    }
};
</script>
<style scoped>
@import '../../css/styles.scss';
</style>
