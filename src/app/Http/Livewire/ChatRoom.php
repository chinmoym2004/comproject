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
    public $total_message_count=0;
    protected $listeners = ['triggerRefresh' => '$refresh','addMember','selectedFromSearch','removeMember'];
    public $chat_messages;
    public $members = null;
    public $selected_id = null;

    public $memberupdateMode=false;

    protected $rules = [
        'chat_text'=>'required',
        'uploads.*' => 'file|max:2048', // 1MB Max
    ];

    public $uploads=[];

    private function resetInput()
    {
        $this->selected_id = null;
        $this->member_ids = [];
        $this->members = null;
        $this->memberupdateMode = false;        
    }

    public function mount($chat)
    {
        $this->chat = $chat;
    }

    public function cancel()
    {
        $this->memberupdateMode = false;
        $this->resetInput();
    }

    public function render()
    {
        $me = Auth::user();

        $tmp_messages = [];

        $megs = $this->chat->messages()->orderBy('id','ASC')->get();

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
        return view('livewire.chat-room');
    }

    public function saveChat()
    {
        //dd($this->chat);
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
        $this->allow_search = 0;
        $this->chat_text='';
        $this->emit('triggerRefresh');
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
}
