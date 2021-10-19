<?php

namespace App\Http\Livewire;
use App\Models\Chat;
use App\Models\ChatUser;
use Livewire\Component;
use App\Models\Message;
use Auth;
use App\Events\ChatBroadcast;
use Livewire\WithFileUploads;
use App\Models\Upload;

class ChatControl extends Component
{
    use WithFileUploads;

    public $rooms;
    public $active_room;

    public $see_members=0;
    public $upload_file=0;

    public $chat_participants;
    public $chat_messages;
    public $last_chat_message;
    public $chat;

    public $search = '';

    public $perPage = 100;
    protected $listeners = ['load-more' => 'loadMore']; //'echo-private:chat-7-messages,ChatBroadcast' => 'notifyNewMesage'
    public $last_message = 'Never';

    public $uploads=[];
    public $chat_text;

    protected $rules = [
        'uploads.*' => 'file|max:1024', // 1MB Max
    ];

    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
    }

    public function render()
    {
        $me = Auth::user();

        // check all where user created it or part of it 
        $chat_ids = ChatUser::where('user_id',$me->id)->pluck('chat_id')->toArray();
        $this->rooms = Chat::search($this->search)->whereIn('id',$chat_ids)->orderBy('created_at','ASC')->get();

        return view('livewire.chat-control');
    }

    public function clearChat()
    {
        $this->chat=null;
        $this->chat_participants  = []; 
        $this->chat_messages = [];
        $this->last_chat_message = []; 
        $this->chat_text ='';
        $this->see_members=0;
        $this->uploads=null;
    }

    public function loadChatRoom($chat_id)
    {
        $this->chat_messages=null;
        $me = Auth::user();

        $chat = Chat::find(decrypt($chat_id));
        
        if($chat)
        {
            $this->last_message = $chat->messages()->latest()->first()?$chat->messages()->latest()->first()->created_at->diffForHumans():'Never';


            if(isset($this->active_room) && $this->active_room!=$chat->id)
            {
                // clear previous chat
                $this->clearChat();
            }
            $this->chat = $chat;

            $this->active_room = $chat->id;

            $tmp_messages = [];

            $megs = $chat->messages()->orderBy('id','ASC')->paginate($this->perPage);

            foreach($megs as $msg)
            {
                $user = $msg->user;
                $tmp['user']=['name'=>$user->name,'_id'=>encrypt($user->id),'avatar'=>$user->image()];
                $tmp['message']=['body'=>$msg->body,'time'=>date('Y-m-d H:i:s',strtotime($msg->created_at))];
                $tmp['files'] = $msg->upload;
                $tmp['is_me']=$msg->user_id==$me->id?1:0;
                $tmp_messages[]=$tmp;
            }
            
            $this->chat_messages = $tmp_messages;
            $this->chat_participants = $chat->members()->pluck('name','user_id')->toArray();
            $this->dispatchBrowserEvent('chatloaded', ['action' => 'message_loaded']);
        }
    }

    public function saveChat()
    {
        $this->validate();


        $pattern = "/member:\d/i";
        $tobetagged = [];
        if(preg_match_all($pattern, $this->chat_text, $matches)) {
            foreach($matches[0] as $member)
            {
                $tobetagged[] = explode(":",$member)[1];
            }
        }
        
        $user = Auth::user();

        $message = new Message;
        $message->chat_id = $this->chat->id;
        $message->body = $this->chat_text;
        $message->user_id = $user->id;
        $message->save();

        // Inbox user of they are tagged 
        if(count($tobetagged))
        {
            foreach($tobetagged as $usr)
            {
                $this->chat->notifiable()->create([
                    'show_text'=>'Mentioned you in a chat <b>'.$this->chat->title.'</b>',
                    'action_by'=>$user->id,
                    'user_id'=>$usr,
                    'redirect_url'=>url('chat-room?uid='.encrypt($this->chat->id).'&mid='.encrypt($message->id))
                ]);
            }
        }

        if($this->uploads)
        {
            foreach ($this->uploads as $file) {
                $uploadfile = new Upload;
                $filedata = $uploadfile->saveFile($file,'Message');
                $filedata['uploaded_by']=$user->id;
                $filedata['is_thumbnail']=0;
                $message->upload()->create($filedata);
            }
        }
        

        $data=[
            'chat_id'=>$message->chat_id,
            'message'=>$message->body,
            'user_name'=>$message->user->name,
            'profile_image'=>asset('img/user-placeholder.png'),
            'time'=>date('Y-m-d H:i:s',strtotime($message->created_at))
        ];

        $tmp['user']=['name'=>$user->name,'_id'=>encrypt($user->id),'avatar'=>$user->image()];
        $tmp['message']=['body'=>$message->body,'time'=>date('Y-m-d H:i:s',strtotime($message->created_at))];
        $tmp['files'] = $message->upload;
        $tmp['is_me']=$message->user_id==$user->id?1:0;

        $this->chat_messages[]=$tmp;

        $this->dispatchBrowserEvent('chatSaved', ['action' => 'created','data'=>$data]);

        event(new ChatBroadcast($data));

        //$this->allow_search = 0;
        $this->chat_text='';
    }

    public function viewmembers($chat_id)
    {
        $chat = Chat::find(decrypt($chat_id));
        if($chat)
        {
            $this->chat_participants = $chat->members;
            $this->see_members = 1;
            $this->dispatchBrowserEvent('chatMembersloaded', ['action' => 'viewmember']);
        }
    }

    public function uploadFile($chat_id)
    {
        $chat = Chat::find(decrypt($chat_id));
        if($chat)
        {
            $this->upload_file = 1;
            $this->dispatchBrowserEvent('upoadFile', ['action' => '']);
        }
        
    }

    public function addmember($chat_id)
    {

    }

    public function downloadFile($id){
        $id = decrypt($id);
        $file = Upload::find($id);

        if(!$file)
            abort(404);

        return \Storage::disk('public')->download($file->file_loc);
        //return response()->download(storage_path('public/'.$file->file_loc),$file->file_name);
    }

    public function notifyNewMesage()
    {
        info("Notification channel");
    }
}
