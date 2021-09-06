<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Auth;
use App\Models\Chat;
use App\Models\User;
use App\Models\Group;

class AdminChatComponent extends Component
{
    use WithPagination;

    public $sortField = 'title'; // default sorting field
    public $sortAsc = true; // default sort direction
    public $search = '';

    protected $listeners = ['delete', 'triggerRefresh' => '$refresh','triggerEdit','chatMembersSelected','fetchGroupForChargroup'];

    public $title;
    public $member_ids=[];
    public $selected_id;
    public $members;
    public $updateMode = false;
    public $perpage = 10;
    public $groups=null;
    public $is_public=false;
    public $group_id=false;
    public $createMode=false;

    protected $rules = [
        'title'=>'required',
        'group_id'=>'required'
    ];

    private function resetInput()
    {
        $this->chat_id = null;
        $this->title = null;
        $this->is_public = false;
        $this->groups = null;
        $this->group_id = null;
    }

    public function fetchGroupForChargroup()
    {
        $this->groups = Group::all();
        $this->createMode = true;
        $this->dispatchBrowserEvent('groupdataFetchedForChat');
    }

    public function chatMembersSelected($chatMembers)
    {
        $this->member_ids = $chatMembers;
    }


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } 
        else 
        {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $chats = Chat::search($this->search)
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate($this->perpage);

        return view('livewire.chats.component',['chats'=>$chats]);
    }

    public function submit()
    {
        //dd($this->validate());

        $this->validate();
        $user = Auth::user();
        try
        {
            $record = Chat::create([
                'title' => $this->title,
                'is_public' => $this->is_public,
                'group_id' => $this->group_id,
                'user_id' => $user->id
            ]);

            $selecetd_members = Group::find($this->group_id)->members()->pluck('user_id')->toArray();
            $record->members()->sync($selecetd_members);
            
            session()->flash('success','Category Created Successfully!!');

            $this->resetInput();
            $this->dispatchBrowserEvent('group-saved', ['action' => 'created', 'group_title' => $this->title]);
            $this->emit('triggerRefresh');

            $this->createMode=false;
            
        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating category!!');
            // Reset Form Fields After Creating Category
            $this->resetInput();
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInput();
    }

    public function triggerEdit($id)
    {
        $record = Chat::find($id);

        $this->groups = Group::all();

        $this->selected_id = $record->id;

        $this->title = $record->title;
        $this->group_id = $record->group_id;
        $this->is_public = $record->is_public;
        $this->updateMode = true;

        $this->emit('dataFetched', $record);
    }

    public function update()
    {
        $this->validate();

        try
        {
            $record = Chat::find($this->selected_id);
            
            $record->update([
                'title' => $this->title,
                'is_public' => $this->is_public,
                'group_id' => $this->group_id
            ]);

            $selecetd_members = Group::find($this->group_id)->members()->pluck('user_id')->toArray();
            $record->members()->sync($selecetd_members);

            session()->flash('success','Category Updated Successfully!!');
            $this->cancel();
            //$this->dispatchBrowserEvent('group-saved', ['action' => 'created', 'group_title' => $this->title]);
            $this->emit('triggerRefresh');

            //dd($record);

        }catch(\Exception $e){
            report($e);
            session()->flash('error','Something goes wrong while updating category!!');
            $this->cancel();
        }

    }

    public function destroy($id)
    {
        //$id = decrypt($id);
        
        if ($id) {
            $record = Chat::where('id', $id);
            $record->delete();
            $this->dispatchBrowserEvent('chat-grpup-deleted', ['title' => $chat->title]); // add this
        }
    }

    public function start1to1chat($user_id)
    {
        if ($user_id) 
        {
            $user_id = decrypt($user_id);
            $chatwith = User::find($user_id);
            $me = Auth::user();

            $record = Chat::create([
                'title' => $chatwith->name.",".$me->name,
                'user_id' => $me->id
            ]);

            $selecetd_members = [$chatwith->id,$me->id];

            $record->members()->sync($selecetd_members);
            
            $this->dispatchBrowserEvent('chat-box-open', ['title' => $record->title,'redirect_to'=>url('/chat-rooms/'.encrypt($record->id))]); // add this
        }
    }
}
