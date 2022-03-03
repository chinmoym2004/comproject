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
    public $upload_file=0,$messages_count=0;

    public $chat_participants;
    public $chat_messages=[];
    public $last_chat_message;
    public $chat;
    public $chat_id=0;
    public $here = [];

    public $search = '';

    public $perPage = 10;
    protected $listeners = [
        'loadMore',
        'triggerRefresh' => '$refresh',
        'echo-presence:txchat,here' => 'here',
        'echo-presence:txchat,joining' => 'joining',
        'echo-presence:txchat,leaving' => 'leaving',
    ];
    public $last_message = 'Never';

    public $uploads=[];
    public $chat_text;
    public $tag_members='';
    public $unreadedMessages=0;

    protected $rules = [
        'uploads.*' => 'file|max:1024', // 1MB Max
    ];

    public function mount()
    {
        $this->unreadedMessages = Auth::user()->unreadedMessages()->count();
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
        if(isset($this->active_room))
            $this->loadChatRoom(encrypt($this->active_room));

        $this->emit('load');
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
        $this->messages_count=0;
        $this->perPage=10;
        $this->chat_participants  = []; 
        $this->chat_messages = [];
        $this->last_chat_message = []; 
        $this->chat_text ='';
        $this->see_members=0;
        $this->uploads=null;
    }

    public function loadChatRoom($chat_id)
    {                
        $me = Auth::user();

        $chat = Chat::find(decrypt($chat_id));

        // Set all as unread
        $this->dispatchBrowserEvent('hasRead', ['resetid' => 'unread'.$chat->id]);

        // set user's last active status 
        $this->setLastActive($me->id,$chat->id);
        
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

            $this->messages_count = $chat->messages()->count();

            $megs = $chat->messages()
            ->orderBy('id','ASC')
            ->skip($this->messages_count - $this->perPage)
            ->take($this->perPage)
            ->get();

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
            $this->tag_members =  json_encode($this->chat->members()->selectRaw('user_id as id,name as text')->get()->makeHidden('pivot'));

            if($this->perPage==10)
                $this->dispatchBrowserEvent('chatloaded', ['action' => 'message_loaded']);
        }
    }

    public function setLastActive($user_id,$chat_id)
    {
        \DB::table('chat_user')->where(['chat_id'=>$chat_id,'user_id'=>$user_id])->update(['last_active'=>date('Y-m-d H:i:s')]);
    }

    public function saveChat()
    {
        $this->dispatchBrowserEvent('hasRead', ['resetid' => 'unread'.$this->chat->id]);
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

        $this->chat_id = $this->chat->id;

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
        $tmp['chat_id']=$message->chat_id;

        //$this->chat_messages[]=$tmp;
        array_push($this->chat_messages, $tmp);

        broadcast(new ChatBroadcast($tmp))->toOthers();

        $this->dispatchBrowserEvent('chatSaved', ['action' => 'created','data'=>$data]);

        //event(new ChatBroadcast($data));

        // Set last active time
        $this->setLastActive($user->id,$message->chat_id);

        //$this->allow_search = 0;
        $this->chat_text='';
        $this->uploads=[];
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

    /**
     * @param $message
     */
    public function incomingMessage($data)
    {
        //dd($data);
        // get the hydrated model from incoming json/array.
        //$message = Message::with('user')->find($message['id']);
        $data['is_me']=0;
        if(is_array($data) && $data['chat_id']==$this->active_room)
        {
            array_push($this->chat_messages, $data);
        }

        $unread = Auth::user()->unreadedMessages($data['chat_id'])->count();
        $this->dispatchBrowserEvent('justNotify',['resetid' => 'unread'.$data['chat_id'],'count'=>$unread]);
    }

    /**
     * @param $data
     */
    public function here($data)
    {
        $this->here = $data;
    }

    /**
     * @param $data
     */
    public function leaving($data)
    {
        // $here = collect($this->here);

        // $firstIndex = $here->search(function ($authData) use ($data) {
        //     return $authData['id'] == $data['id'];
        // });
        // $here->splice($firstIndex, 1);
        // $this->here = $here->toArray();
    }

    /**
     * @param $data
     */
    public function joining($data)
    {
        $this->here[] = $data;
    }

    public function markasread($chat_id){
        $me = Auth::user();
        $this->dispatchBrowserEvent('hasRead', ['resetid' => 'unread'.$chat_id]);
        // set user's last active status 
        $this->setLastActive($me->id,$chat_id);
    }
}
