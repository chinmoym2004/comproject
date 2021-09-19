<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Forum;
use Auth;
use App\Models\Category;
use App\Models\Group;
use Illuminate\Validation\Rule;

class ForumControl extends Component
{
    use WithPagination;

    public $sortField = 'name'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['forum-delete', 'triggerRefresh' => '$refresh','triggerForumEdit','destroyForum','fetchCategory'];

    public $name,$campus,$school,$program,$details,$category_id,$group_id,$is_public;
    public $member_ids=[];
    public $selected_id;
    public $members;
    public $updateMode = false;

    public $createMode = false;

    public $categories=null;
    public $groups=null;

    protected $rules = [
        'campus'=>'required',
        'school'=>'required',
        'program'=>'required',
        'name'=>'required',
        'is_public'=>'required',
        'group_id'=>'sometimes|required',
        'category_id'=>'required'
    ];

    private function resetInput()
    {
        $this->forum_id = null;
        $this->name = null;
        $this->categories = null;
        $this->groups = null;
        $this->campus=null;
        $this->school=null;
        $this->program=null;
        $this->details=null;
        $this->category_id=null;
        $this->group_id=null;
        $this->is_public=0;
    }

    public function fetchCategory()
    {
        $this->createMode = true;
        $this->categories = Category::all();
        $this->groups = Group::all();
        $this->emit('categoryFetched');
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
                'campus'=>$this->campus,
                'school'=>$this->school,
                'program'=>$this->program,
                'details'=>$this->details,
                'group_id'=>$this->group_id,
                'is_public'=>$this->is_public,
                'category_id'=>$this->category_id,
                'post_count'=>0,
                'topic_count'=>0,
                'user_id' => $user->id,
                'slug'=>uniqid()
            ]);
            
            //session()->flash('success','Forum Created Successfully!!');
            $this->dispatchBrowserEvent('forum-saved', ['action' => 'created', 'title' => $this->name]);
            $this->emit('triggerRefresh');
            $this->createMode=false;

        }catch(\Exception $e){
            report($e);
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
                'name' => $this->name,
                'campus'=>$this->campus,
                'school'=>$this->school,
                'program'=>$this->program,
                'details'=>$this->details,
                'group_id'=>$this->group_id,
                'is_public'=>$this->is_public,
                'category_id'=>$this->category_id
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

        $this->campus=$record->campus;
        $this->school=$record->school;
        $this->program=$record->program;
        $this->details=$record->details;

        $this->group_id=$record->group_id;
        $this->is_public=$record->is_public;
        $this->category_id=$record->category_id;

        $this->updateMode = true;
        $this->categories = Category::all();
        $this->groups = Group::all();
        
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

    public function approveForum($id)
    {
        if ($id) 
        {
            $user = Auth::user();

            $record = Forum::find($id);
            $record->published = 1;
            $record->published_by = $user->id;
            $record->published_at = date('Y-m-d H:i:s');
            $record->save();
        }
    }

    public function UndoapproveForum($id)
    {
        if ($id) 
        {
            $user = Auth::user();

            $record = Forum::find($id);
            $record->published = 0;
            $record->published_by = $user->id;
            $record->published_at = date('Y-m-d H:i:s');
            $record->save();
        }
    }

    
}
