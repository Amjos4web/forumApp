// this is what I have in app.js

require('./bootstrap');

import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

window.Vue = require('vue');

Vue.component('message', require('./components/message.vue'));

const app = new Vue({
    el: '#app',
    data: {
        message: '',
        chat: {
            message:[],
            user:[],
            color:[],
        },
    },
    
    methods: {
        send(){
            if (this.message.length != 0){
                this.chat.message.push(this.message);
                this.chat.user.push("You");
                this.chat.color.push("success");
                axios.post('/send', {
                    message : this.message,
                  })
                  .then(response =>  {
                    console.log(response);
                    this.message = '';
                  })
                  .catch(error =>  {
                    console.log(error);
                  });
            }
            
        }
    },

    mounted() {
        Echo.private('chat')
            .listen('ChatEvent', (e) => {
                this.chat.message.push(e.message); 
                this.chat.user.push(e.user);
                this.chat.color.push("warning");
                console.log(e);
        }).catch(error => {
            console.log(error);
        });
    }
    
});


// this is what I have in my ChatEvent I created

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $message;
    public $user;
    
    public function __construct($message,User $user)
    {
        $this->message = $message;
        $this->user = $user->name;
        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }
}

// this is my controller
public function send(Request $request)
{
    return $request->all();
    $user = User::find(Auth::id());
    broadcast (new ChatEvent($request->message, $user));

}

// and I use this code below to authenticate the chat private channel
Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat', function(){
    return true;
});

// and I have the csrf token in my app.blade.php header file
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
