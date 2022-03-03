<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\User;
use App\Models\ChatUser;
use App\Models\Message;
use Auth;
use App\Events\ChatBroadcast;
use Livewire\WithFileUploads;
use App\Models\Upload;

class ChatRoom extends Component
{
    use WithFileUploads;

    public $member_ids=[];
    public Chat $chat;
    public $chat_text='';
    public $cmessages;
    public $allow_search = 0;
    public $total_message_count=0,$messages_count=0;
    public $tag_members='';

    protected $listeners = [
        'triggerRefresh' => '$refresh',
        'addMember',
        'selectedFromSearch',
        'removeMember',
        'tagableUserList',
        'closeTagableUserList',
        'loadMore',
        'echo-presence:txchat,here' => 'here',
        'echo-presence:txchat,joining' => 'joining',
        'echo-presence:txchat,leaving' => 'leaving',
    ];

    public $chat_messages;
    public $members = null;
    public $selected_id = null;
    public $uploads=[];

    public $memberupdateMode=false;
    public $enabletag = false;
    public $taggableusers = null;
    public $taggedusers = [];

    public $last_message = 'Never';

    public $perPage = 10;

    protected $rules = [
        'uploads.*' => 'file|max:2048', // 1MB Max
    ];

    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
        $this->loadChatRoom(encrypt($this->active_room));

        $this->emit('load');
    }
    

    private function resetInput()
    {
        $this->selected_id = null;
        $this->member_ids = [];
        $this->members = null;
        $this->memberupdateMode = false;  
        $this->enabletag = false;  
        $this->taggedusers = [];    
    }

    public function mount($chat)
    {
        $this->chat = $chat;
        $this->active_room = $chat->id;
    }

    public function cancel()
    {
        $this->memberupdateMode = false;
        $this->resetInput();

        // $this->resetErrorBag();
        // $this->resetValidation();
    }

    public function render()
    {
        $me = Auth::user();

        $chat = $this->chat;
        
        
        $this->last_message = $chat->messages()->latest()->first()?$chat->messages()->latest()->first()->created_at->diffForHumans():'Never';


        if(isset($this->active_room) && $this->active_room!=$chat->id)
        {
            // clear previous chat
            $this->clearChat();
        }
        $this->chat = $chat;

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
        
        // $me = Auth::user();

        // $tmp_messages = [];

        // $megs = $this->chat->messages()->orderBy('id','ASC')->get();

        // foreach($megs as $msg)
        // {
        //     $user = $msg->user;
        //     $tmp['user']=['name'=>$user->name,'_id'=>encrypt($user->id),'avatar'=>$user->image()];
        //     $tmp['message']=['body'=>$msg->body,'time'=>date('Y-m-d H:i:s',strtotime($msg->created_at))];
        //     $tmp['files'] = $msg->upload;
        //     $tmp['is_me']=$msg->user_id==$me->id?1:0;
        //     $tmp_messages[]=$tmp;
        // }
        
        // $this->chat_messages = $tmp_messages;
        return view('livewire.chat-room');
    }

    public function saveChat()
    {
        //dd($this->chat_text);

        $pattern = "/member:\d/i";
        $tobetagged = [];
        if(preg_match_all($pattern, $this->chat_text, $matches)) {
            foreach($matches[0] as $member)
            {
                $tobetagged[] = explode(":",$member)[1];
            }
        }

        $this->validate();

        $user = Auth::user();

        $message = new Message;
        $message->chat_id = $this->chat->id;
        $message->body = $this->chat_text;
        $message->user_id = $user->id;
        $message->save();

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


        $this->chat_messages[]=$tmp;

        broadcast(new ChatBroadcast($tmp))->toOthers();

        $this->dispatchBrowserEvent('chatSaved', ['action' => 'created','data'=>$data]);

        $this->allow_search = 0;
        $this->chat_text='';
        $this->uploads=[];
        $this->emit('triggerRefresh');
    }

    protected function addonetonechatmember($chatwith_name,$chatwith_id,$me)
    {
        if ($chatwith_name && $chatwith_id && $me) 
        {
            $record = Chat::where(['user_id'=>$me->id,'one_to_one_user_id'=>$chatwith_id])->first();
            if(!$record)
            {
                $record = Chat::where(['user_id'=>$chatwith_id,'one_to_one_user_id'=>$me->id])->first();
                if(!$record)
                {
                    $record = Chat::create([
                        'title' => $chatwith_name.','.$me->name,
                        'user_id' => $me->id,
                        'one_to_one_user_id'=>$chatwith_id
                    ]);
                }
            }
            $selecetd_members = [$chatwith_id,$me->id];
            $record->members()->sync($selecetd_members);

            return $record;
        }
    }

    public function start1to1chat($user_id)
    {
        if ($user_id) 
        {
            $user_id = decrypt($user_id);
            $chatwith = User::find($user_id);
            $me = Auth::user();

            // check if already exist then start that only
            $record = $this->addonetonechatmember($chatwith->name,$chatwith->id,$me);
            // $record = Chat::whereRaw("(title='".$chatwith->name."' AND user_id='".$me->id."') OR (title='".$me->name."' AND user_id='".$chatwith->id."')")->first();
            // if(!$record)
            // {
            //     $record = Chat::create([
            //         'title' => $chatwith->name, //.",".$me->name
            //         'user_id' => $me->id
            //     ]);
    
            //     $selecetd_members = [$chatwith->id,$me->id];
    
            //     $record->members()->sync($selecetd_members);
            // }
            
            $this->dispatchBrowserEvent('chat-box-open', ['title' => $record->title,'redirect_to'=>url('/chat-rooms/'.encrypt($record->id))]); // add this
        }
    }

    public function addMember($id)
    {
        $record = Chat::find($id);

        $this->selected_id = $record->id;
        $this->members = $record->members??null; //?$record->members()->pluck('user_id')->toArray():
        $this->memberupdateMode = true;

        $this->dispatchBrowserEvent('chatMemberDataFetched');
    }

    public function selectedFromSearch($data)
    {
        $this->member_ids[$data['id']]=$data['text'];
    }

    public function unselectMember($id)
    {
        unset($this->member_ids[$id]);
    }

    public function removeMember($id)
    {
        $record = Chat::find($this->selected_id);
        if($id)
        {
            $record->members()->detach($id);
            $this->dispatchBrowserEvent('memberRemoved',['id'=>$id]);
        }

    }

    public function updateMember()
    {
        $record = Chat::find($this->selected_id);
        $member_id_keys = array_keys($this->member_ids);
        if(count($member_id_keys))
        {
            $record->members()->attach($member_id_keys);
        }

        $this->emit('triggerRefresh');
        $this->dispatchBrowserEvent('memberUpdated');
        $this->memberupdateMode = false;
        $this->resetInput();
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

    public function tagableUserList($id)
    {
        $record = Chat::find($id);
        $this->taggableusers = $record->members??null;
        $this->enabletag = true;
    }

    public function closeTagableUserList($id)
    {
        $this->enabletag = false;
        $this->taggableusers = [];
    }

    public function selectedTagUser($id)
    {
        $user = User::find($id)->name;
        $this->taggedusers[$id]=$user;

        $this->enabletag = false;
        $this->taggableusers = [];

        $this->dispatchBrowserEvent('userselectedtotag', ['name' => $user,'id'=> $id]);
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
        
        $this->dispatchBrowserEvent('justNotify');
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
}
