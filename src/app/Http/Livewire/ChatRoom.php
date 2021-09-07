<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\User;
use App\Models\ChatUser;
use App\Models\Messages;
use Auth;
use App\Events\ChatBroadcast;
use Livewire\WithFileUploads;

class ChatRoom extends Component
{
    use WithFileUploads;

    public Chat $chat;
    public $chat_text='';
    public $cmessages;
    public $allow_search = 0;
    //public $uploads=[];


    protected $listeners = [''];

    protected $rules = [
        'chat_text'=>'required',
        //'uploads.*' => 'file|max:2048', // 1MB Max
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

        // if($this->uploads)
        // {
        //     foreach ($this->uploads as $file) {
        //         info(print_r($file));
        //     }
        // }


        $data=[
            'chat_id'=>$message->chat_id,
            'message'=>$message->body,
            'user_name'=>$message->user->name,
            'profile_image'=>asset('img/user-placeholder.png'),
            'time'=>$message->created_at
        ];
        
        $this->dispatchBrowserEvent('chatSaved', ['action' => 'created','data'=>$data]);

        event(new ChatBroadcast($data));

        $this->allow_search = 0;

        $this->chat_text='';
        
    }

    public function start1to1chat($user_id)
    {
        if ($user_id) 
        {
            $user_id = decrypt($user_id);
            $chatwith = User::find($user_id);
            $me = Auth::user();

            // check if already exist then start that only
            $record = Chat::whereRaw("(title='".$chatwith->name."' AND user_id='".$me->id."') OR (title='".$me->name."' AND user_id='".$chatwith->id."')")->first();
            if(!$record)
            {
                $record = Chat::create([
                    'title' => $chatwith->name, //.",".$me->name
                    'user_id' => $me->id
                ]);
    
                $selecetd_members = [$chatwith->id,$me->id];
    
                $record->members()->sync($selecetd_members);
            }
            
            $this->dispatchBrowserEvent('chat-box-open', ['title' => $record->title,'redirect_to'=>url('/chat-rooms/'.encrypt($record->id))]); // add this
        }
    }

    public function addMembers()
    {
        $this->allow_search=1;
        $this->dispatchBrowserEvent('openSearch', ['action' => 'search']);
    }
}
