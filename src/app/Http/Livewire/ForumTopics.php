<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use App\Models\Topic;
use Livewire\Component;
use Auth;
class ForumTopics extends Component
{
    use WithPagination;

    public $sortField = 'created_at'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['destroyTopic', 'triggerRefresh' => '$refresh','triggerTopicEdit','chatMembersSelected'];

    public $title,$body;
    public $forum;

    public $member_ids=[];
    public $selected_id;
    public $members;
    public $updateMode = false;

     public $perpage = 20;

    protected $rules = [
        'title'=>'required'
    ];

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

    public function mount($forum)
    {
        $this->forum = $forum;
    }

    public function render()
    {
        $topics = Topic::search($this->search)
        ->where('forum_id',$this->forum->id)
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate($this->perpage);

        return view('livewire.forum-topics',['topics'=>$topics]);
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
            
            //session()->flash('success','Forum Created Successfully!!');
            $this->dispatchBrowserEvent('topic-saved', ['action' => 'created', 'title' => $this->title]);
            $this->emit('triggerRefresh');
        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating forum!!');
            // Reset Form Fields After Creating Category
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
