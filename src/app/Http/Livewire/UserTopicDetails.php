<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use App\Models\Topic;

class UserTopicDetails extends Component
{
    public $topic; 
    public $enablereply=false;
    public $comment_text;
    public $reference_id;

    public function mount($topic)
    {   
        $this->topic = $topic;
        $this->reference_id = $topic->id;
    }

    protected $listeners = ['triggerRefresh' => '$refresh','commentCreated'];

    
    public function render()
    {
        return view('livewire.user-topic-details',['topic'=>$this->topic]);
    }

    public function upvote($id)
    {
        $user = Auth::user();
        $thread = Topic::find($id);
        $voted = $thread->useractions($user->id)->where('action_type','=',1)->first();
        if($voted)
        {
            $voted->delete();
            $this->dispatchBrowserEvent('upvoted', ['action' => 'undoupvote']);
        }
        else
        {
            $thread->action()->create([
                'user_id'=>$user->id,
                'action_type'=>'upvote'
            ]);

            $this->dispatchBrowserEvent('upvoted', ['action' => 'upvote']);
        }
        
    }

    public function actionEnablereply()
    {
        $this->enablereply = !$this->enablereply;
    }

    public function saveTopicComment($parent_id=null)
    {
        $this->validate([
            'comment_text'=>'required'
        ]);

        $user = Auth::user();

        $topic = Topic::find($this->reference_id); 

        $topic->comments()->create([
            'comment_text'=>$this->comment_text,
            'user_id'=>$user->id,
            'parent_id'=>$parent_id,
        ]);
        $this->enablereply = 0;
        $this->comment_text = null;
        $this->emit('triggerRefresh');
    }

    public function commentCreated()
    {
        $this->emit('triggerRefresh');
    }
}
