<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Topic;
use Auth;

class UserForumTopics extends Component
{
    public $forum;

    public $sortField = 'created_at'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['destroyTopic', 'triggerRefresh' => '$refresh','triggerTopicEdit','chatMembersSelected'];

    public $title,$body;
    public $member_ids=[];
    public $selected_id;
    public $members;
    public $updateMode = false;

    protected $rules = [
        'title'=>'required'
    ];

    public function mount($forum)
    {
        $this->forum = $forum;
    }

    public function render()
    {
        $threads = $this->forum->topics;
        return view('livewire.user-forum-topics',['threads'=>$threads]);
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

    private function resetInput()
    {
        $this->title = null;
        $this->body = null;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInput();
    }
    
    public function submit()
    {
        $this->validate();

        $user = Auth::user();

        try
        {
            $this->forum->topics()->create([
                'title' => $this->title,
                'body'=>$this->body,
                'user_id'=>$user->id,
                'status' => 'Active',
                'slug'=>uniqid()
            ]);
            
            if(isset($this->forum->topic_count))
                $this->forum->topic_count+=1;
            else
                $this->forum->topic_count=1;
            $this->forum->save();
            $this->dispatchBrowserEvent('topic-saved', ['action' => 'created', 'title' => $this->title]);
            $this->emit('triggerRefresh');
        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating forum!!');
            $this->resetInput();
        }
    }

    public function destroyTopic($id)
    { 
        if ($id) {
            $record = Topic::find($id);
            $name = $record->title;
            $record->delete();

            if(!isset($this->forum->topic_count))
                $this->forum->topic_count=0;
            else
                $this->forum->topic_count-=1;

            $this->forum->save();
            
            $this->dispatchBrowserEvent('topic-deleted', ['title' => $name]); // add this
        }
    }

    public function triggerTopicEdit($id)
    {
        $record = Topic::find($id);

        $this->selected_id = $record->id;
        $this->title = $record->title;
        $this->body = $record->body;
        $this->updateMode = true;
        $this->emit('topicDataFetched', $record);
    }

    public function update()
    {
        $this->validate();

        try
        {
            $record = Topic::find($this->selected_id);
            $record->update([
                'title' => $this->title,
                'body'  => $this->body
            ]);
            
            $this->dispatchBrowserEvent('topic-updated', ['action' => 'updated', 'title' => $this->title]);
            $this->resetInput();
            $this->emit('triggerRefresh');

            //dd($record);

        }catch(\Exception $e){
            report($e);
            session()->flash('error','Something goes wrong while updating category!!');
            $this->cancel();
        }
    }
}
