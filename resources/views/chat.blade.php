@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-md-offset-2 position-relative">
                    <div class="panel-heading">Chats</div>
                    <transition name="bounce">
                        <span class="text" v-if="show">Chúc em giang sinh vui vẻ hạnh phúc nhé !</span>
                    </transition>
                    <div class="fireworks-example">
                    </div>
                    <div class="panel-body body-chat" ref="messagesContainer">
                        <chat-messages
                            :messages="messages"
                            :selecthover="selected"
                            v-on:hoveritemmessage="hoverItemMessage"
                            v-on:outhover="outHover"
                        ></chat-messages>
                    </div>
                    <div class="panel-footer">
                        <chat-form
                            v-on:messagesent="addMessage"
                            v-on:clearmessageall="clearMessage"
                            v-on:handleinputchat="handleInputChat"
                            v-on:updatetype="updateType"
                            :user="{{ \Illuminate\Support\Facades\Auth::user() }}"
                        ></chat-form>
                    </div>
            </div>
        </div>
    </div>
@endsection
