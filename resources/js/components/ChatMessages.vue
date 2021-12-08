<template>
    <ul class="chat list-style-none">
        <li class="left clearfix" v-for="message in messages">
            <div class="chat-body clearfix flex" :class="{'right': message.position === 'right', 'left': message.position === 'left','padding-right-26': !message.showIcon}">
                <p :class="{'chat-me': message.position === 'right', 'chat-dont-me': message.position === 'left'}">
                    {{ message.message }}
                </p>
                <iframe v-if="message.showIcon && message.position === 'right'" class="check-send" width="20px" height="20px" src="./image/check.svg"></iframe>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    props: ['messages']
};
</script>
