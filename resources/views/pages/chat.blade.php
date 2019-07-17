@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12" id="app">
            <li class="list-group-item active" style="font-size: 20px; text-transform: uppercase; text-align: center">Conversation Room</li>
            <ul class="list-group" id="messages" v-chat-scroll>
                <message 
                    v-for="value,index in chat.message" 
                    :key=value.index
                    :color = chat.color[index]
                    :user = chat.user[index]
                >
                    @{{ value }}
                </message>
            </ul>
            <input type="text" v-model="message" @keyup.enter="send" class="form-control" placeholder="Type your message">
        </div> 
    </div>
</div>
@endsection
