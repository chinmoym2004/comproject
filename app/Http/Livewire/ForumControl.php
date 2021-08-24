<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Forum;
use Auth;

class ForumControl extends Component
{
    use WithPagination;

    public $sortField = 'name'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['forum-delete', 'triggerRefresh' => '$refresh','triggerForumEdit','destroyForum'];

    public $name;
    public $member_ids=[];
    public $selected_id;
    public $members;
    public $updateMode = false;

    protected $rules = [
        'name'=>'required',
    ];

    private function resetInput()
    {
        $this->forum_id = null;
        $this->name = null;
        $this->member_ids = [];
        $this->members = null;
    }

    public function chatMembersSelected($chatMembers)
    {
        $this->member_ids = $chatMembers;
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

    public function render()
    {
        $forums = Forum::search($this->search)
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate(20);

        return view('livewire.forum-control',['forums'=>$forums]);
    }

    public function submit()
    {
        $this->validate();

        $user = Auth::user();

        try
        {
            Forum::create([
                'name' => $this->name,
                'post_count'=>0,
                'topic_count'=>0,
                'user_id' => $user->id
            ]);
            
            //session()->flash('success','Forum Created Successfully!!');
            $this->dispatchBrowserEvent('forum-saved', ['action' => 'created', 'title' => $this->name]);
            $this->emit('triggerRefresh');
        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating forum!!');
            // Reset Form Fields After Creating Category
            $this->resetInput();
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInput();
    }

    public function update()
    {
        $this->validate();

        try
        {
            $record = Forum::find($this->selected_id);
            $record->update([
                'name' => $this->name
            ]);
            //session()->flash('success','Category Updated Successfully!!');
            
            $this->dispatchBrowserEvent('forum-updated', ['action' => 'updated', 'title' => $this->name]);
            $this->resetInput();
            $this->emit('triggerRefresh');

            //dd($record);

        }catch(\Exception $e){
            report($e);
            session()->flash('error','Something goes wrong while updating category!!');
            $this->cancel();
        }

    }

    public function triggerForumEdit($id)
    {
        $record = Forum::find($id);

        $this->selected_id = $record->id;
        $this->name = $record->name;
        $this->updateMode = true;
        $this->emit('forumDataFetched', $record);
    }

    public function destroyForum($id)
    { 
        if ($id) {
            $record = Forum::find($id);
            $name = $record->name;

            $record->delete();
            $this->dispatchBrowserEvent('forum-deleted', ['title' => $name]); // add this
        }
    }
}
