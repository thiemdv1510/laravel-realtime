<template>
    <ul class="chat list-style-none">
        <li @mouseover="hoverItemMessage(message.id)" @mouseleave="outHover" class="clearfix" :class="{'justify-end': message.position === 'right', 'justify-start': message.position === 'left'}" v-for="message in messages">
            <div class="chat-body clearfix flex direction-column" :class="{'right': message.position === 'right', 'left': message.position === 'left','padding-right-26': !message.showIcon}">
                <span class="format-sub-info padding-right-5 right" v-if="message.position === 'right' && selectHover === message.id">{{message.date}} </span>
                <span class="format-sub-info padding-left-5 left" v-if="message.position === 'left' && selectHover === message.id">{{message.date}} </span>
                <div :class="{'direction-row': message.showIcon && message.position === 'right'}">
                    <p :class="{'chat-me': message.position === 'right', 'chat-dont-me': message.position === 'left', 'padding-left-16': message.showIcon && message.position === 'right'}">
                        {{ message.message }}
                    </p>
                    <iframe v-if="message.showIcon && message.position === 'right'" class="check-send" width="20px" height="20px" src="./image/check.svg"></iframe>
                </div>

            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['messages'],
    data() {
        return {
            selectHover: null
        }
    },
    methods: {
        hoverItemMessage (id) {
            this.selectHover = id
        },
        outHover () {
            this.selectHover = null
        }
    }
};
</script>
<style scoped>
@import '../../css/styles.scss';
</style>
