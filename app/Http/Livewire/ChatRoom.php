<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Messages;
use Auth;

class ChatRoom extends Component
{
    public Chat $chat;
    public $chat_text='';
    public $cmessages;


    //protected $listeners = ['delete', 'sendChatMesage'];

    protected $rules = [
        'chat_text'=>'required',
    ];

    public function mount($chat)
    {
        $this->chat = $chat;
        $this->cmessages = $chat->messages ?? null;
    }

    public function render()
    {
        return view('livewire.chat-room');
    }

    public function saveChat()
    {
        $this->validate();

        $user = Auth::user();

        $message = new Messages;
        $message->chat_id = $this->chat->id;
        $message->body = $this->chat_text;
        $message->user_id = $user->id;
        $message->save();

        $this->chat_text='';
        $this->dispatchBrowserEvent('chatSaved', ['action' => 'created']);
    }
}
