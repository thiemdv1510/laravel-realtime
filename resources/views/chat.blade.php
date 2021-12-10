@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Chats</div>

                    <div class="panel-body body-chat">
                        <chat-messages :messages="messages"></chat-messages>
                    </div>
                    <div class="panel-footer">
                        <chat-form
                            v-on:messagesent="addMessage"
                            v-on:clearmessageall="clearMessage"
                            :user="{{ \Illuminate\Support\Facades\Auth::user() }}"
                        ></chat-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
