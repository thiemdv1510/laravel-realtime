<template>
        <ul class="chat list-style-none">
            <li @click="hoverItemMessage(message.id)" @mouseover="hoverItemMessage(message.id)" @mouseleave="outHover" class="clearfix" :class="{'justify-end': message.position === 'right', 'justify-start': message.position === 'left'}" v-for="message in messages">
                <div class="chat-body clearfix flex direction-column" :class="{'right': message.position === 'right', 'left': message.position === 'left','padding-right-26': !message.showIcon}">
                    <span class="format-sub-info padding-right-5 right" v-if="message.position === 'right' && select === message.id">{{message.date}} </span>
                    <span class="format-sub-info padding-left-5 left" v-if="message.position === 'left' && select === message.id">{{message.date}} </span>
                    <div :class="{'direction-row': message.showIcon && message.position === 'right'}">
                        <div class="content" v-if="message.type === 0" v-html="nl2br(message.message)" :class="{'chat-me': message.position === 'right', 'chat-dont-me': message.position === 'left', 'padding-left-16': message.showIcon && message.position === 'right'}">
                        </div>
                        <img class="image" v-viewer width="auto" height="200" v-if="message.type === 1" :src="'http://18.140.3.232/images/'+message.message" alt="">
                        <iframe v-if="message.showIcon && message.position === 'right'" :class="message.read === 1 ? 'check-sended' : 'check-send'" width="20px" height="20px" src="./image/check.svg"></iframe>
                    </div>
                </div>
            </li>
        </ul>
</template>

<script>
import 'viewerjs/dist/viewer.css'
import Viewer from 'v-viewer'
import Vue from 'vue'
Vue.use(Viewer)
export default {
    props: ['messages', 'selecthover'],
    data() {
        return {
            url: window.location.hostname
        }
    },
    computed: {
        select: {
            get() {
                return this.selecthover
            }
        }
    },
    watch: {
        messages() {
            for (const i in this.messages) {
                const check = this.messages[i].message.split('.')
                console.log(check.length)
                if (check.length === 2 && check[0].length === 10) {
                    this.messages[i].type = 1
                }
            }
        }
    },

    methods: {
        nl2br (str, is_xhtml) {
            if (typeof str === 'undefined' || str === null) {
                return '';
            }
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        },
        hoverItemMessage (id) {
            this.$emit('hoveritemmessage', id)
        },
        outHover () {
            this.$emit('outhover')
        }
    },
};
</script>
<style scoped>
.image {
    border-radius: 9px;
    box-shadow: 3px 3px 11px 1px #d8d8d8;
    margin-bottom: 5px;
}
@import '../../css/styles.scss';
</style>
